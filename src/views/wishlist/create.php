<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Wishlist */
/* @var $gifts app\models\Gift[] */
/* @var $categories app\models\GiftCategory[] */

$this->title = 'Создание списка желаний';
$this->params['breadcrumbs'][] = ['label' => 'Списки желаний', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wishlist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'gifts' => $gifts,
        'categories' => $categories,
    ]) ?>

</div>