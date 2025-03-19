<?php
use yii\helpers\Html;

?>
<div class="contact-info p-5 mt-5 px-3 rounded bg-white animate__animated animate__fadeInRight">
    <div class="text-center">
        <h4 class="text-primary">TJSL/CSR</h4>
        <p class="text-muted f-18">Ganti Password</p>
    </div>

    <div class="custom-form">
        <?= \hail812\adminlte\widgets\FlashAlert::widget() ?>
        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
            <div class="mt-3">
                <?= Html::submitButton('Ganti Password', ['class' => 'btn btn-primary btn-block text-uppercase']) ?>
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