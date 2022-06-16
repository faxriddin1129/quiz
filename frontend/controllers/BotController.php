<?php

namespace frontend\controllers;

use common\models\Token;
use frontend\models\TgUser;
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

//        if ($this->phone){
//            $modelNew = new TgUser();
//            $modelNew->fullName = $this->full_Name;
//            $modelNew->money = 10000;
//            $modelNew->tg_user_id = $this->userId;
//            $modelNew->tg_chat_id = $this->chatId;
//            $modelNew->tg_phone = $this->phone;
//            $modelNew->username = $this->username;
//            if ($modelNew->validate()){
//                $this->main();
//            }
//            $this->bot(Token::sendMessage,[
//                'chat_id'=>$this->chatId,
//                'text'=> $modelNew->tg_phone,
//            ]);
//        }

        if ($this->text == '/start'){ $this->main();}
        if ($this->text == '/contact'){ $this->contact();}
        if ($this->text == '/menu'){ $this->main(); }
        if ($this->text == '💵 Hisobni to`ldirish'){ $this->payment(); }
        if ($this->text == '📌 YO`RIQNOMA!'){ $this->rules(); }


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



    public function rules(){
        $this->bot(Token::sendMessage,[
            'chat_id'=>$this->chatId,
            'text'=> Token::RULES,
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


}