<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Gift */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Подарки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="gift-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот подарок?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-md-8">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'description:ntext',
                    'price:currency',
                    [
                        'attribute' => 'link',
                        'format' => 'url',
                    ],
                    [
                        'attribute' => 'category_id',
                        'value' => $model->category ? $model->category->name : 'Не указана',
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= Html::img($model->getImageUrl(), ['class' => 'img-responsive']) ?>
        </div>
    </div>
</div>