<?php

namespace common\models;

use Yii;
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

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tg_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['money',], 'integer'],
            [['tg_user_id', 'tg_chat_id','tg_phone'], 'integer'],
            [['username', 'fullName'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'tg_user_id' => Yii::t('app', 'Tg User ID'),
            'tg_chat_id' => Yii::t('app', 'Tg Chat ID'),
            'tg_phone' => Yii::t('app', 'Tg Phone'),
            'money' => Yii::t('app', 'Money'),
            'fullName' => Yii::t('app', 'Full Name'),
        ];
    }
}
