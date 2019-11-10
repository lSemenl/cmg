<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Room;

/**
 * RoomSearch represents the model behind the search form of `app\models\Room`.
 */
class RoomSearch extends Room
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'capacity'], 'integer'],
            [['isProjector', 'isMarkerBoard', 'isConferenceCall'], 'boolean'],
            [['name'], 'safe'],
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

    public function stringToBool($param)
    {
        if (mb_strtolower($param, 'UTF-8') == 'да') {
            $param = 1;
        } else if (mb_strtolower($param, 'UTF-8') == 'нет') {
            $param = 0;
        }
        return $param;
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
        $query = Room::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $isProjector = '';
        $isMarkerBoard = '';
        $isConferenceCall = '';
        if (array_key_exists('RoomSearch', $params)) {
            $isProjector = $params['RoomSearch']['isProjector'];
            $isMarkerBoard = $params['RoomSearch']['isMarkerBoard'];
            $isConferenceCall = $params['RoomSearch']['isConferenceCall'];
            $params['RoomSearch']['isProjector'] = $this->stringToBool($isProjector);
            $params['RoomSearch']['isMarkerBoard'] = $this->stringToBool($isMarkerBoard);
            $params['RoomSearch']['isConferenceCall'] = $this->stringToBool($isConferenceCall);
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
            'capacity' => $this->capacity,
            'isProjector' => $this->isProjector,
            'isMarkerBoard' => $this->isMarkerBoard,
            'isConferenceCall' => $this->isConferenceCall,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        if (array_key_exists('RoomSearch', $params)) {
            $this->setAttributes([
                'isProjector' => $isProjector,
                'isMarkerBoard' => $isMarkerBoard,
                'isConferenceCall' => $isConferenceCall,
            ]);
        }

        return $dataProvider;
    }
}
