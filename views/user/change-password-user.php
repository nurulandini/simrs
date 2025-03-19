<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use \yiister\gentelella\widgets\FlashAlert;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\ChangePassword */

$this->title = 'Ubah Password';
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['id' => 'form-change']); ?>
        <?= $form->field($model, 'newPassword')->passwordInput()->label('Password Baru') ?>
        <?= $form->field($model, 'retypePassword')->passwordInput()->label('Ketik Ulang Password Baru') ?>
        <?php if (!Yii::$app->request->isAjax) { ?>
            <div class="form-group">
                <?= Html::submitButton('Ganti', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php } ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>