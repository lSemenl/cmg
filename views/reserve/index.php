<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\widgets\Pjax;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ReserveSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Бронирования';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserve-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать бронирвоание', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'format' => 'text',
                'label' => 'Номер',
            ],
            [
                'attribute' => 'room_id',
                'format' => 'raw',
                'label' => 'Комната',
                'value' => function ($data) {
                    $url=Yii::$app->getUrlManager()->createUrl(['/room/view','id'=>$data->room_id]);
                    return Html::a($data->room_id, $url);
                },
            ],
            [
                'attribute' => 'meeting_date',
                'format' => 'text',
                'label' => 'Дата',
                'value' => function ($data) {
                    return date('d.m.Y', strtotime($data->meeting_date));
                },
            ],
            [
                'attribute' => 'start_date',
                'format' => 'text',
                'label' => 'Время начала',
            ],
            [
                'attribute' => 'end_date',
                'format' => 'text',
                'label' => 'Время окончания',
            ],
            [
                'attribute' => 'owner_id',
                'format' => 'text',
                'label' => 'Пользователь',
                'value' => function ($data) {
                    return app\models\User::findOne(['id' => $data->owner_id])->getAttribute('username');
                },
            ],
            [
                'class' => ActionColumn::className(),
                'template'=> '{view} {update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        if (Yii::$app->user->getIsGuest()) {
                            return false;
                        }
                        if (Yii::$app->user->getId() !== $model->getAttribute('owner_id') &&
                            !User::findOne(['id' => Yii::$app->user->getId()])->getAttribute('is_admin')) return false;
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, []);
                    },
                    'delete' => function ($url, $model, $key) {
                        if (Yii::$app->user->getIsGuest()) {
                            return false;
                        }
                        if (Yii::$app->user->getId() !== $model->getAttribute('owner_id') &&
                            !User::findOne(['id' => Yii::$app->user->getId()])->getAttribute('is_admin')) {
                            return false;
                        }
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['data-method' => "post"]);
                    },
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
