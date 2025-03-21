<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Gift */
/* @var $categories app\models\GiftCategory[] */

$this->title = 'Изменение подарка: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Подарки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="gift-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>