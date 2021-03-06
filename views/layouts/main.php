<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>


<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);


    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            [
                'label' => 'Home',
                'url' => ['site/index'],
                'linkOptions' => [],
            ],
            ['label' => 'Menu', 'url' => ['/menu-food/index']],
            ['label' => 'Order', 'url' => ['/order/create']],
            [
                'label' => 'My Order',
                'url' => ['/order/my-order'],
                'visible' => !Yii::$app->user->isGuest
            ],

            [
                'label' => 'Manage Food',
                'url' => ['/food'],
                'visible' => Yii::$app->user->can('admin')
            ],
            [
                'label' => 'Manage Menu',
                'url' => ['/menu'],
                'visible' => Yii::$app->user->can('admin')
            ],
            [
                'label' => 'Manage Order',
                'url' => ['/order'],
                'visible' => Yii::$app->user->can('admin')
            ],
            [
                'label' => 'Assign Food To Menu',
                'url' => ['/menu-food/create'],
                'visible' => Yii::$app->user->can('admin')
            ],
            [
                'label' => 'Manage User',
                'url' => ['/user/admin'],
                'visible' => Yii::$app->user->can('admin')
            ],


            [
                'label' => 'My Account',
                'items' => [
                    ['label' => 'Account', 'url' => ['/user/account']],
                    '<li class="divider"></li>',
                    ['label' => 'Profile', 'url' => ['/user/profile']],
                ],
                'visible' => !Yii::$app->user->isGuest
            ],
            Yii::$app->user->isGuest ? (
            ['label' => 'Login', 'url' => ['/user/login']]
            ) :
                (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
                )
        ],

    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
