<?php

namespace frontend\controllers;

use common\models\Contact;
use common\models\TgUser;
use common\models\Token;
use yii\web\Controller;

class BotController extends Controller
{
    public $layout = false;
    public $enableCsrfValidation = false;
    public $chatId;
    public $text;
    public $full_Name;
    public $userId;
    public $phone;
    public $username;


    public function actionIndex(){
        $updates = json_decode(file_get_contents('php://input'),true);
        $message = $updates['message'];
        $from = $message['from'];
        $chat = $message['chat'];
        $this->userId = $from['id'];
        $this->username = $from['username'];
        $this->chatId = $chat['id'];
        $this->text = $message['text'];
        $this->full_Name = $from['first_name'].' '.$from['last_name'];
        $this->phone = $updates['message']['contact']['phone_number'];
        $check = TgUser::findOne(['tg_chat_id'=>$this->chatId]);

        if ($this->phone) {
            if (!$check){
                $db = \Yii::$app->db;
                $db->createCommand('INSERT INTO `tg_user` (`tg_phone`,`username`,`fullName`,`money`,`tg_user_id`,`tg_chat_id`) VALUES (:tg_phone, :username, :fullName, :money, :tg_user_id, :tg_chat_id)', [
                    ':tg_phone' => $this->phone,
                    ':username' => $this->username,
                    ':fullName' => $this->full_Name,
                    ':tg_user_id' => $this->userId,
                    ':tg_chat_id' => $this->chatId,
                    ':money' => 10000,
                ])->execute();
            }
            $this->main();
            die();
        }

        if (!$check){
            $this->contact();
        }

        if ($check){
            if ($this->text === '/start'){ $this->main();}
            if ($this->text === '/contact'){ $this->contact();}
            if ($this->text === '/menu'){ $this->main(); }
            if ($this->text === '💵 Hisobni to`ldirish'){ $this->payment(); }
            if ($this->text === '📌 YO`RIQNOMA!'){ $this->rules(); }
            if ($this->text === '📝 Ma`lumotlarim'){ $this->personal(); }
            if ($this->text === '💬 Adminga Murojaat'){ $this->admin(); }
            if ($this->text === '👥 Muhokami Guruhi'){ $this->group(); }
        }
    }


    public function contact(){
        $keyboard = json_encode([
            'keyboard'=>[
                [
                    [
                        'text'=>'📞 Contact',
                        'request_contact'=>true
                    ],
                ],
            ],
            'resize_keyboard'=>true
        ]);
        $this->bot(Token::sendMessage,[
            'chat_id'=>$this->chatId,
            'text'=> '<b>Assalom alaykum'."\n".'</b> Parvoz O`quv Markazi QuizTest Botiga Xush Kelibsiz'."\n".'Tizimdan Foydalanish uchun Contact ni Taqdim Eting',
            'parse_mode'=>'html',
            'reply_markup'=>$keyboard
        ]);
    }


    public function main(){
        $keyboard = json_encode([
            'keyboard'=>[
                [
                    ['text'=>'📚 Test olish'],
                    ['text'=>'🔑 Test javoblarini tekshirish']
                ],
                [
                    ['text'=>'📝 Ma`lumotlarim'],
                    ['text'=>'💵 Hisobni to`ldirish']
                ],
                [
                    ['text'=>'💬 Adminga Murojaat'],
                    ['text'=>'📌 YO`RIQNOMA!']
                ],
                [
                    ['text'=>'👥 Muhokami Guruhi'],
                ],
            ],
            'resize_keyboard'=>true
        ]);
        $this->bot(Token::sendMessage,[
            'chat_id'=>$this->chatId,
            'text'=> 'Parvoz O`quv Markazi QuizTest Xizmatlari',
            'parse_mode'=>'html',
            'reply_markup'=>$keyboard
        ]);
    }


    public function payment(){
        $keyboard = json_encode([
            'inline_keyboard'=>[
                [
                    ['text'=>'Click', 'callback_data' => 'Click'],
                    ['text'=>'Apelsin', 'callback_data' => 'Apelsin'],
                    ['text'=>'Payme', 'callback_data' => 'Payme'],
                ],
            ],
            'resize_keyboard'=>true
        ]);
        $this->bot(Token::sendMessage,[
            'chat_id'=>$this->chatId,
            'text'=> 'O`zingizga Maqul To`lov Tizimini Tanlang',
            'parse_mode'=>'html',
            'reply_markup'=>$keyboard
        ]);
    }


    public function personal(){
        $data = TgUser::findOne(['tg_chat_id'=>$this->chatId]);
        $this->bot(Token::sendMessage,[
            'chat_id'=>$this->chatId,
            'text'=> "👨‍🎓<b>Ism Familiyaingiz: </b> $data->fullName \n 📞 <b> Telefoningiz: </b> $data->tg_phone \n 💴 <b> Balansingiz: </b> $data->money <b>UZS</b>",
            'parse_mode'=>'html',
        ]);
    }



    public function rules(){
        $this->bot(Token::sendMessage,[
            'chat_id'=>$this->chatId,
            'text'=> Contact::findOne(['id'=>1])->description,
        ]);
    }



    public function bot($method,$data = [],$token = Token::TOKEN){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,'https://api.telegram.org/bot'.$token.'/'.$method);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $res = curl_exec($ch);
        return json_decode($res);
    }

    public function admin(){
        $this->bot(Token::sendMessage,[
            'chat_id'=>$this->chatId,
            'text'=>"<b>👨‍⚖️ Sardor Xolmurodov</b>\n ------------------------------------- \n <b>📞 +998888158822</b>\n ------------------------------------- \n <b>💬 @Sardor8822 👈</b>",
            'parse_mode'=>'html',
        ]);
    }

    public function group(){
        $this->bot(Token::sendMessage,[
            'chat_id'=>$this->chatId,
            'text'=> "<strong><a href='https://t.me/starter_Gr123'>Parvoz Quiz Test Guruhi 👈</a></strong>",
            'parse_mode'=>'html',
        ]);
    }


}