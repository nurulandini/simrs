<?php

use kartik\time\TimePicker;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\DataJadwalPegawai */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-jadwal-pegawai-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pegawai_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\app\models\DataPegawai::find()->all(), 'id', 'nama'),
        'options' => ['placeholder' => 'Pilih Pegawai', 'id' => 'pegawai_id', 'class' => 'form-control selects'],
    ]) ?>

    <?= $form->field($model, 'hari_kerja')->dropDownList([
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu'
    ], ['prompt' => 'Pilih Jadwal Shift']) ?>

    <?= $form->field($model, 'shift')->dropDownList([1 => 'Pagi', 0 => 'Sore'], ['prompt' => 'Pilih Jadwal Shift']) ?>

    <?= $form->field($model, 'mulai')->widget(MaskedInput::class, [
        'mask' => '99:99',
        'options' => ['class' => 'form-control', 'placeholder' => 'HH:MM']
    ]) ?>

    <?= $form->field($model, 'akhir')->widget(MaskedInput::class, [
        'mask' => '99:99',
        'options' => ['class' => 'form-control', 'placeholder' => 'HH:MM']
    ]) ?>



    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>