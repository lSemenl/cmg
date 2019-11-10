<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Reserve;

/**
 * ReserveSearch represents the model behind the search form of `app\models\Reserve`.
 */
class ReserveSearch extends Reserve
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'room_id'], 'integer'],
            [['owner_id'], 'integer'],
            [['meeting_date', 'start_date', 'end_date'], 'safe'],
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
        $query = Reserve::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $username = '';
        if (array_key_exists('ReserveSearch', $params)) {
            $username = $params['ReserveSearch']['owner_id'];
            if ($user = User::findOne(['username' => $username])) {
                $params['ReserveSearch']['owner_id'] = $user->getId();
            }
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'room_id' => $this->room_id,
            'meeting_date' => $this->meeting_date,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'owner_id' => $this->owner_id,
        ]);

        if (array_key_exists('ReserveSearch', $params)) {
            $this->setAttribute('owner_id', $username);
        }
        return $dataProvider;
    }
}
