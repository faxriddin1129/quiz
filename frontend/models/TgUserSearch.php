<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TgUser;

/**
 * TgUserSearch represents the model behind the search form of `common\models\TgUser`.
 */
class TgUserSearch extends TgUser
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tg_user_id'], 'integer'],
            [['username', 'tg_chat_id', 'tg_phone', 'money', 'fullName'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TgUser::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tg_user_id' => $this->tg_user_id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'tg_chat_id', $this->tg_chat_id])
            ->andFilterWhere(['like', 'tg_phone', $this->tg_phone])
            ->andFilterWhere(['like', 'money', $this->money])
            ->andFilterWhere(['like', 'fullName', $this->fullName]);

        return $dataProvider;
    }
}
