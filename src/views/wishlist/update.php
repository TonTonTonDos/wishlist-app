<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Wishlist */
/* @var $gifts app\models\Gift[] */
/* @var $categories app\models\GiftCategory[] */

$this->title = 'Изменение списка желаний: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Списки желаний', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="wishlist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'gifts' => $gifts,
        'categories' => $categories,
    ]) ?>

</div>