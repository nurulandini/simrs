<?php

use yii\helpers\Html;

$this->registerCssFile('@web/css/custom.css', [
    'depends' => 'yii\bootstrap4\BootstrapAsset'
]);

$this->title = 'Reset Password';
?>
<div class="container">
    <div class="row">
        <div class="contact-info reset-password p-5 px-3 rounded animate__animated animate__fadeInRight">
            <div class="text-center">
                <h4 class="text-primary">TJSL/CSR</h4>
                <p class="text-muted f-18">Reset Password</p>
            </div>

            <div class="custom-form">
                <?= \hail812\adminlte\widgets\FlashAlert::widget() ?>
                <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'request-password-reset-form']) ?>
                <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')])->label(false) ?>
                <div class="mt-3">
                    <?= Html::submitButton('Reset Password', ['class' => 'btn btn-primary btn-block text-uppercase']) ?>
                </div>
                <?php \yii\bootstrap4\ActiveForm::end(); ?>

                <div class="mt-4 pt-1 mb-0 text-center">
                    <?= Html::a('<i class="mdi mdi-lock"></i> Masuk? Klik disini.', ['site/login'], ['class' => 'text-dark']) ?>
                </div><br>
                <div class="col-12 mt-3 text-center text-muted text-sm">
                    Bappeda Kota Medan &copy; <?= date('Y') ?>
                </div>
            </div>
        </div>
    </div>
</div>