<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use app\models\Room;

/* @var $this yii\web\View */
/* @var $model app\models\Reserve */

$this->title = 'Редактирование бронирования: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Бронирования', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирвоание';
?>
<div class="reserve-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'room-form']); ?>

            <?= $form->field($model, 'room_id')
                ->dropDownList(ArrayHelper::map(Room::find()->all(),'id','name'));
            ?>

            <?= $form->field($model, 'meeting_date')
                ->widget(DatePicker::className(), [
                    'name' => 'check_issue_date',
                    'value' => '123123',
                    'options' => ['placeholder' => 'Выберите дату'],
                    'pluginOptions' => [
                        'format' => 'dd.m.yyyy',
                        'todayHighlight' => true
                    ]
                ])
            ?>

            <?= $form->field($model, 'start_date')
                ->label('Время начала')
                ->widget(TimePicker::className(), [
                    'name' => 'start_time',
                    'value' => '12:00',
                    'pluginOptions' => [
                        'showSeconds' => false,
                        'showMeridian' => false,
                    ]
                ])
            ?>

            <?= $form->field($model, 'end_date')
                ->label('Время окончания')
                ->widget(TimePicker::className(), [
                    'name' => 'end_date',
                    'value' => '12:00',
                    'pluginOptions' => [
                        'showSeconds' => false,
                        'showMeridian' => false,
                    ]
                ])
            ?>

            <?= $form->field($model, 'verify_code')->widget(Captcha::className(), [
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
