<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reserve".
 *
 * @property int $id
 * @property int $room_id
 * @property string $meeting_date
 * @property string $start_date
 * @property string $end_date
 * @property int $owner_id
 * @property int $verifyCode;
 *
 * @property User $owner
 * @property Room $room
 */
class Reserve extends \yii\db\ActiveRecord
{
    public $verify_code;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reserve';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['room_id', 'meeting_date', 'start_date', 'end_date', 'owner_id'], 'required'],
            [['room_id', 'owner_id'], 'integer'],
            [['meeting_date'], 'date', 'format' => 'php:Y-m-d'],
            [['start_date', 'end_date'], 'time', 'format' => 'php:H:i'],
            [['meeting_date', 'start_date', 'end_date'], 'validateDate'],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Room::className(), 'targetAttribute' => ['room_id' => 'id']],
            [['verify_code'], 'captcha'],
        ];
    }

    public function validateDate($attribute, $params)
    {
        if (strtotime($this->meeting_date . ' ' . $this->start_date) < strtotime(date('d.m.Y H:i'))) {
            $this->addError($attribute, 'Начало бронирования не может быть меньше текущей даты');
        }
        $diff = strtotime($this->end_date) - strtotime($this->start_date);
        if ($diff < 0) {
            $this->addError($attribute, 'Время начала должно быть меньше времени окончания');
        } else if ($diff / 60 < 30) {
            $this->addError($attribute, 'Минимальное время бронирования - 30 минут');
        } else if (($diff / 60) % 15 != 0) {
            $this->addError($attribute, 'Время бронирования должно быть кратно 15 минутам');
        }

        $reserves = Reserve::find()
            ->where(['=', 'room_id', $this->room_id])
            ->andWhere(['<>', 'id', $this->id])
            ->andWhere(['=', 'meeting_date', date('Y-m-d', strtotime($this->meeting_date))])
            ->andWhere(['or', ['between', 'start_date', $this->start_date, $this->end_date], ['between', 'end_date', $this->start_date, $this->end_date]])
            ->all();
        if (count($reserves) > 0) {
            $this->addError($attribute, 'Комната на это время уже занята');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер',
            'room_id' => 'Номер комнаты',
            'meeting_date' => 'Дата встречи',
            'start_date' => 'Дата начала',
            'end_date' => 'Дата окончания',
            'verify_code' => 'Проверочный код',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(Room::className(), ['id' => 'room_id']);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $this->meeting_date = date('Y-m-d', strtotime($this->meeting_date));
        return parent::save($runValidation = true, $attributeNames = null);
    }
}
