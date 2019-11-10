<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Room */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Комнаты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="room-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
        ],
    ]) ?>

</div>
