<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Списки желаний';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wishlist-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать список желаний', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'is_public',
                'format' => 'boolean',
                'label' => 'Публичный',
            ],
            [
                'label' => 'Публичная ссылка',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->is_public && $model->public_token) {
                        return Html::a('Открыть', $model->getPublicUrl(), [
                            'class' => 'btn btn-xs btn-primary',
                            'target' => '_blank',
                            'data-toggle' => 'tooltip',
                            'title' => $model->getPublicUrl()
                        ]);
                    } else {
                        return '<span class="not-set">(не публичный)</span>';
                    }
                },
            ],
            [
                'label' => 'Подарки',
                'value' => function ($model) {
                    return count($model->gifts);
                },
            ],
            [
                'label' => 'Категории',
                'value' => function ($model) {
                    return count($model->categories);
                },
            ],
            'created_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>