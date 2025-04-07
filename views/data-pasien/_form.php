<?php

use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\DataPasien */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-pasien-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nik')->textInput([
        'type' => 'number',
        'maxlength' => 16,
        'oninput' => "this.value = this.value.slice(0, 16)"
    ]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jenis_kelamin')->dropDownList([1 => 'Laki - Laki', 0 => 'Perempuan'], ['prompt' => 'Pilih Jenis Kelamin']) ?>

    <?= $form->field($model, 'tempat_lahir')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'tanggal_lahir')->widget(DatePicker::className(), [
        'options' => ['placeholder' => 'Pilih Tanggal', 'id' => 'tanggal_lahir'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'nomor_hp')->widget(MaskedInput::classname(), [
        'mask' => '9',
        'clientOptions' => ['repeat' => 12, 'greedy' => false],
    ])->label(true) ?>

    <?= $form->field($model, 'alamat')->textarea(['rows' => 6]) ?>

    <?= $form->field($model_kecamatan, 'kecamatan_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\app\models\WilayahKecamatan::find()->where(['kabupaten_kota_id' => 26])->all(), 'id', 'kecamatan'),
        'options' => ['placeholder' => 'Pilih Kecamatan', 'id' => 'kecamatan_id', 'class' => 'form-control selects'],
    ]) ?>

    <div id="kelurahan_id_div">
        <?= $form->field($model, 'kelurahan_id')->widget(DepDrop::classname(), [
            'type' => DepDrop::TYPE_SELECT2,
            'options' =>
            [
                'id' => 'kelurahan_id',
            ],
            'select2Options' =>
            [
                'pluginOptions' =>
                [
                    'dropdownParent' => '#kelurahan_id_div',
                ]
            ],
            'pluginOptions' =>
            [
                'depends' => ['kecamatan_id'],
                'url' => Url::to(['get-kelurahan-json']),
                'placeholder' => 'Pilih Kelurahan',
                'initialize' => true,
            ]
        ]) ?>
    </div>



    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
