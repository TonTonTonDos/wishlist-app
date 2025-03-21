<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Wishlist */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Списки желаний', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="wishlist-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот список желаний?',
                'method' => 'post',
            ],
        ]) ?>
        <?php if ($model->is_public): ?>
            <?= Html::a('Публичная ссылка', $model->getPublicUrl(), [
                'class' => 'btn btn-success',
                'target' => '_blank',
            ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            'is_public:boolean',
            [
                'attribute' => 'public_token',
                'visible' => $model->is_public,
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->getPublicUrl(), $model->getPublicUrl(), ['target' => '_blank']);
                },
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <h2>Категории</h2>
    <?php if (!empty($model->categories)): ?>
        <div class="categories">
            <?php foreach ($model->categories as $category): ?>
                <span class="label label-info"><?= Html::encode($category->name) ?></span>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Нет связанных категорий</p>
    <?php endif; ?>

    <h2>Подарки</h2>
    <?php if (!empty($model->gifts)): ?>
        <?= GridView::widget([
            'dataProvider' => new ArrayDataProvider([
                'allModels' => $model->gifts,
                'pagination' => false,
            ]),
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
                [
                    'attribute' => 'link',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if ($model->link) {
                            return Html::a('Перейти', $model->link, [
                                'target' => '_blank',
                                'class' => 'btn btn-xs btn-default',
                            ]);
                        }
                        return '<span class="not-set">(не указана)</span>';
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                                ['gift/view', 'id' => $model->id],
                                ['title' => 'View', 'data-pjax' => '0']);
                        },
                    ],
                ],
            ],
        ]); ?>
    <?php else: ?>
        <p>Нет связанных подарков</p>
    <?php endif; ?>
</div>