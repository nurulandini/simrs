<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use AWS\CRT\Options;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\web\View;

AppAsset::register($this);
\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700');
$this->registerCssFile('@web/css/custom.css', [
    'depends' => 'yii\bootstrap4\BootstrapAsset'
]);
?>
<?php $this->beginPage() ?>



<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>

</head>


<body>

    <header>
        <?php
        NavBar::begin([
            'brandLabel' => Html::img('@web/img/logo.png', ['style' => 'width: 50%;max-width:400px; height:auto; ',]),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-expand-md posisi  ',
                'style' => ''
            ],
        ]);
        // echo Nav::widget([
        //     'options' => ['class' => 'nav navbar-nav ml-auto'],
        //     'items' => [
        //         Yii::$app->user->isGuest ? (['label' => 'Login', 'url' => ['/site/login'], 'options' => ['class' => 'nice_div']]
        //         ) : ([
        //             'label' => 'Profil (' . Yii::$app->user->identity->username . ')',
        //             'items' => [
        //                 ['label' => 'Profil', 'url' => ['/user/profil']],
        //                 ['label' => 'Dashboard', 'url' => ['/beranda/beranda']],
        //                 [
        //                     'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
        //                     'url' => ['/site/logout'],
        //                     'linkOptions' => ['data-method' => 'post'],
        //                     'visible' => !Yii::$app->user->isGuest
        //                 ],
        //             ]
        //         ]
        //         )
        //     ],

        // ]);


        NavBar::end();
        ?>

    </header>

    <main role="main" class="flex-shrink-0" style="z-index: 2">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'options' => ['class' => 'bread-crumbs', 'style' => 'margin-bottom : 1rem;padding-top:8rem']
        ]) ?>
        <?= Alert::widget() ?>

        <?= $content ?>
    </main>

    <div class="loading-overlay" id="loadingContainer">
        <div class="loading">
            <div class="box-1"></div>
            <div class="box-2"></div>
        </div>
    </div>

    <footer class="footer py-3 text-muted container">
        <p class="float-left">&copy; SIMRS <?= date('Y') ?></p>
    </footer>

    <?php $this->endBody() ?>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var loadingContainer = document.getElementById("loadingContainer");
        loadingContainer.style.opacity = "0";
        setTimeout(function() {
            loadingContainer.style.display = "none";
        }, 800);
    });
</script>



</html>
<?php $this->endPage() ?>