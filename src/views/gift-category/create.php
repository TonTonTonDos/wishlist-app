<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GiftCategory */

$this->title = 'Создание категории подарков';
$this->params['breadcrumbs'][] = ['label' => 'Категории подарков', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gift-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>