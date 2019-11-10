<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "room".
 *
 * @property int $id
 * @property string $name
 * @property int $capacity
 * @property int $isProjector
 * @property int $isMarkerBoard
 * @property int $isConferenceCall
 *
 * @property Reserve[] $reserves
 */
class Room extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'room';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'capacity', 'isProjector', 'isMarkerBoard', 'isConferenceCall'], 'required'],
            [['capacity', 'isProjector', 'isMarkerBoard', 'isConferenceCall'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер',
            'name' => 'Наименование',
            'capacity' => 'Вместимость',
            'isProjector' => 'Наличие проектора',
            'isMarkerBoard' => 'Наличие маркерной доски',
            'isConferenceCall' => 'Наличие конференцсвязи',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReserves()
    {
        return $this->hasMany(Reserve::className(), ['room_id' => 'id']);
    }
}
