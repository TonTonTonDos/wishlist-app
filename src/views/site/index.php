<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Wishlist - сервис списков желаний';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Wishlist</h1>

        <p class="lead">Создавайте и делитесь списками желаемых подарков.</p>

        <?php if (Yii::$app->user->isGuest): ?>
            <p>
                <?= Html::a('Регистрация', ['/auth/signup'], ['class' => 'btn btn-lg btn-success']) ?>
                <?= Html::a('Вход', ['/auth/login'], ['class' => 'btn btn-lg btn-primary']) ?>
            </p>
        <?php else: ?>
            <p>
                <?= Html::a('Мои списки желаний', ['/wishlist/index'], ['class' => 'btn btn-lg btn-primary']) ?>
                <?= Html::a('Добавить подарок', ['/gift/create'], ['class' => 'btn btn-lg btn-success']) ?>
            </p>
        <?php endif; ?>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Создавайте категории</h2>

                <p>Организуйте свои желания по категориям: электроника, одежда, для дома, хобби и другие. Удобная категоризация поможет вашим друзьям и близким быстрее найти подходящий подарок.</p>

                <?php if (!Yii::$app->user->isGuest): ?>
                    <p><?= Html::a('Управление категориями', ['/gift-category/index'], ['class' => 'btn btn-default']) ?></p>
                <?php endif; ?>
            </div>
            <div class="col-lg-4">
                <h2>Добавляйте подарки</h2>

                <p>Создавайте подробные описания желаемых подарков. Добавляйте фотографии, ссылки на магазины и указывайте приблизительную стоимость, чтобы вашим близким было проще выбрать подарок.</p>

                <?php if (!Yii::$app->user->isGuest): ?>
                    <p><?= Html::a('Мои подарки', ['/gift/index'], ['class' => 'btn btn-default']) ?></p>
                <?php endif; ?>
            </div>
            <div class="col-lg-4">
                <h2>Делитесь списками</h2>

                <p>Создавайте списки желаний для разных поводов: день рождения, свадьба, новоселье, Новый год. Делитесь публичными ссылками на ваши списки с друзьями и близкими через социальные сети или мессенджеры.</p>

                <?php if (!Yii::$app->user->isGuest): ?>
                    <p><?= Html::a('Мои списки желаний', ['/wishlist/index'], ['class' => 'btn btn-default']) ?></p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>