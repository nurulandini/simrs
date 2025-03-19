<?php

use yii\helpers\Html;
use kartik\widgets\Alert;
use yii\bootstrap4\ActiveForm;

$this->title = 'Ubah Password';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card col-md-6">
    <?php $form = ActiveForm::begin(); ?>
    <div class="card-body">
        <?= $form->field($model, 'currentPassword')->passwordInput() ?>
        <?= $form->field($model, 'newPassword')->passwordInput() ?>
        <?= $form->field($model, 'newPasswordConfirm')->passwordInput() ?>
    </div>
    <div class="card-footer">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-outline-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>