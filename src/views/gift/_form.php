<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Gift */
/* @var $form yii\widgets\ActiveForm */
/* @var $categories app\models\GiftCategory[] */
?>

<div class="gift-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map($categories, 'id', 'name'),
        ['prompt' => 'Выберите категорию']
    ) ?>

    <?php if ($model->image): ?>
        <div class="form-group">
            <label>Текущее изображение</label>
            <div>
                <?= Html::img($model->getImageUrl(), ['class' => 'img-thumbnail', 'style' => 'max-width:200px;']) ?>
            </div>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>