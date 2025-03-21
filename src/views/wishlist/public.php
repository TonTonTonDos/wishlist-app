<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Wishlist */

$this->title = $model->name;
?>
<div class="wishlist-public">

    <div class="jumbotron">
        <h1><?= Html::encode($model->name) ?></h1>
        <?php if ($model->description): ?>
            <p><?= Html::encode($model->description) ?></p>
        <?php endif; ?>
    </div>

    <?php if (!empty($model->categories)): ?>
        <h2>Категории</h2>
        <div class="categories">
            <?php foreach ($model->categories as $category): ?>
                <span class="label label-info"><?= Html::encode($category->name) ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <h2>Подарки</h2>
    <?php if (!empty($model->gifts)): ?>
        <div class="row">
            <?php foreach ($model->gifts as $gift): ?>
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?= Html::encode($gift->name) ?></h3>
                        </div>
                        <div class="panel-body text-center">
                            <?= Html::img($gift->getImageUrl(), [
                                'class' => 'img-responsive center-block',
                                'style' => 'max-height: 200px;',
                            ]) ?>

                            <?php if ($gift->description): ?>
                                <p class="text-muted"><?= Html::encode($gift->description) ?></p>
                            <?php endif; ?>

                            <?php if ($gift->price): ?>
                                <p class="lead">Цена: <?= Yii::$app->formatter->asCurrency($gift->price) ?></p>
                            <?php endif; ?>

                            <?php if ($gift->category): ?>
                                <p>Категория: <?= Html::encode($gift->category->name) ?></p>
                            <?php endif; ?>

                            <?php if ($gift->link): ?>
                                <p>
                                    <?= Html::a('Купить', $gift->link, [
                                        'class' => 'btn btn-primary',
                                        'target' => '_blank',
                                    ]) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>В этом списке пока нет подарков</p>
    <?php endif; ?>
</div>