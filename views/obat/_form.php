<?php

use kartik\date\DatePicker;
use kartik\number\NumberControl;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DataObat $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="data-obat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kategori_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\app\models\KategoriObat::find()->all(), 'id', 'kategori'),
        'options' => ['placeholder' => 'Pilih Kategori', 'id' => 'kategori_id', 'class' => 'form-control selects'],
    ]) ?>

    <?= $form->field($model, 'deskripsi')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tanggal_kedaluwarsa')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Masukkan Tanggal Kedaluwarsa'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]);
    ?>

    <?= $form->field($model, 'persediaan')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'prefix' => '',
            'groupSeparator' => '.',
            'radixPoint' => ',',
            'allowMinus' => false,
            'digits' => 1000,
        ],
        'displayOptions' => ['class' => 'form-control kv-monospace'],
    ]) ?>

    <?= $form->field($model, 'satuan_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\app\models\DataSatuan::find()->all(), 'id', 'satuan'),
        'options' => ['placeholder' => 'Pilih Satuan', 'id' => 'satuan_id', 'class' => 'form-control selects'],
    ]) ?>

    <?= $form->field($model, 'harga_per_unit')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'prefix' => '',
            'groupSeparator' => '.',
            'radixPoint' => ',',
            'allowMinus' => false,
            'digits' => 1000,
        ],
        'displayOptions' => ['class' => 'form-control kv-monospace'],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
