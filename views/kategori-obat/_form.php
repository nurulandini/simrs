<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\KategoriObat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kategori-obat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kategori')->textInput(['maxlength' => true]) ?>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>