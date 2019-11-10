<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RoomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Комнаты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= (Yii::$app->user->getId() == 1) ? Html::a('Создать комнату', ['create'], ['class' => 'btn btn-success']) : '' ?>
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
                'attribute' => 'name',
                'format' => 'text',
                'label' => 'Наименование',
            ],
            [
                'attribute' => 'capacity',
                'format' => 'text',
                'label' => 'Вместительность',
            ],
            [
                'attribute' => 'isProjector',
                'format' => 'text',
                'label' => 'Проектор',
                'value' => function ($data) {
                    return $data->isProjector == 1 ? 'Да' : 'Нет';
                },
            ],
            [
                'attribute' => 'isMarkerBoard',
                'format' => 'text',
                'label' => 'Маркерная доска',
                'value' => function ($data) {
                    return $data->isMarkerBoard == 1 ? 'Да' : 'Нет';
                },
            ],
            [
                'attribute' => 'isConferenceCall',
                'format' => 'text',
                'label' => 'Конференцсвязь',
                'value' => function ($data) {
                    return $data->isConferenceCall == 1 ? 'Да' : 'Нет';
                },
            ],
            [
                'class' => yii\grid\ActionColumn::className(),
                'template'=> '{view}  {reserve}  {update}  {delete}',
                'buttons' => [
                    'reserve' => function ($url, $model, $key) {
                        if (Yii::$app->user->getIsGuest()) {
                            return false;
                        }
                        $url=Yii::$app->getUrlManager()->createUrl(['/reserve/create','roomId'=>$model['id']]);
                        return Html::a('<span class="glyphicon glyphicon-book"></span>', $url, []);
                    },
                    'update' => function ($url, $model, $key) {
                        if (Yii::$app->user->getIsGuest()) {
                            return false;
                        }
                        if (!User::findOne(['id' => Yii::$app->user->getId()])->getAttribute('is_admin')) {
                            return false;
                        }
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, []);
                    },
                    'delete' => function ($url, $model, $key) {
                        if (Yii::$app->user->getIsGuest()) {
                            return false;
                        }
                        if (!User::findOne(['id' => Yii::$app->user->getId()])->getAttribute('is_admin')) {
                            return false;
                        }
                        return Html::a('<span class="glyphicon glyphicon-trash" data-method="post"></span>', $url, ['data-method' => "post"]);
                    },
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
