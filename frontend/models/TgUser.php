<?php

namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "tg_user".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $tg_user_id
 * @property string|null $tg_chat_id
 * @property string|null $tg_phone
 * @property int|null $money
 * @property string|null $fullName
 */
class TgUser extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%tg_user}}';
    }

    public function rules()
    {
        return [
            [['money',], 'integer'],
            [['username', 'fullName', 'tg_user_id', 'tg_chat_id', 'tg_phone'], 'string'],
        ];
    }
}
