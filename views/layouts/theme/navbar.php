<?php

use yii\helpers\Html;

?>
<nav class="main-header navbar navbar-expand navbar-dark" style="background-color: #1F439B !important;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <!-- <php Html::img('@web/img/logo.png', ['style' => 'width: 80%;max-width:400px; heigth:auto; ',]); ?> -->
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <img src="<?= yii\helpers\Url::to('@web/img/logo1.png') ?>" alt="" style="width: 5%;">
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expandable="true">
                <i class="fa fa-user-alt"></i> <?= \Yii::$app->user->identity->username ?>
            </a>
            <?php if (!Yii::$app->user->isGuest) { ?>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <?= Html::a('<i class="fa fa-user-alt"></i> Profil', ['user/profil'], ['class' => 'dropdown-item']) ?>
                    <?= Html::a('<i class="fa fa-sign-out-alt"></i> Keluar', ['site/logout'], ['data-method' => 'post', 'class' => 'dropdown-item']) ?>
                </div>
            <?php } else { ?>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <?= Html::a('<i class="fa fa-user-alt"></i> Login', ['site/login'], ['class' => 'dropdown-item']) ?>
                </div>
            <?php } ?>
        </li>
    </ul>
</nav>