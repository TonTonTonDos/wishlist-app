<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Wishlist */
/* @var $form yii\widgets\ActiveForm */
/* @var $gifts app\models\Gift[] */
/* @var $categories app\models\GiftCategory[] */
?>

<div class="wishlist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_public')->checkbox() ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Подарки</h3>
        </div>
        <div class="panel-body">
            <?php if (!empty($gifts)): ?>
                <?= $form->field($model, 'giftIds')->checkboxList(
                    ArrayHelper::map($gifts, 'id', 'name'),
                    ['itemOptions' => ['class' => 'checkbox-inline']]
                ) ?>
            <?php else: ?>
                <div class="alert alert-warning">
                    У вас пока нет подарков. <?= Html::a('Создать подарок', ['gift/create']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Категории</h3>
        </div>
        <div class="panel-body">
            <?php if (!empty($categories)): ?>
                <?= $form->field($model, 'categoryIds')->checkboxList(
                    ArrayHelper::map($categories, 'id', 'name'),
                    ['itemOptions' => ['class' => 'checkbox-inline']]
                ) ?>
            <?php else: ?>
                <div class="alert alert-warning">
                    У вас пока нет категорий. <?= Html::a('Создать категорию', ['gift-category/create']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>