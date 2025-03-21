<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подарки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gift-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать подарок', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'price:currency',
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->category ? $model->category->name : 'Не указана';
                },
            ],
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::img($model->getImageUrl(), ['width' => '50px']);
                },
            ],
            'created_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>