<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DataResepDetail $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="data-resep-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rekam_medis_id')->textInput() ?>

    <?= $form->field($model, 'obat_id')->textInput() ?>

    <?= $form->field($model, 'dosis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>

    <?= $form->field($model, 'biaya')->textInput() ?>

    <?= $form->field($model, 'instruksi')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
