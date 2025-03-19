<?php

use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true])->label("Password") ?>

    <?php
    // Ambil daftar pegawai_id yang sudah terdaftar di tabel user
    $pegawaiIdsInUser = \app\models\User::find()
        ->select('pegawai_id')  // Ambil hanya kolom pegawai_id
        ->column();  // Mengambil data kolom dalam bentuk array

    // Ambil data pegawai yang id-nya tidak ada di dalam daftar pegawai_id user
    $pegawaiList = \app\models\DataPegawai::find()
        ->where(['not in', 'id', $pegawaiIdsInUser])  // Filter pegawai yang belum ada di user
        ->all();  // Ambil semua data pegawai yang memenuhi syarat
    ?>

    <?= $form->field($model, 'pegawai_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($pegawaiList, 'id', 'nama'),  // Data pegawai yang tidak ada di tabel user
        'options' => [
            'placeholder' => 'Pilih Pegawai',
            'id' => 'pegawai_id',
            'class' => 'form-control selects'
        ],
    ]) ?>

    <!-- Peran php format Html::input("text", 'role', null, ['class' => 'form-control',]) -->
    Peran<?= Html::dropDownList('role', null, [
                'administrasi' => 'Administrasi',
                'dokter' => 'Dokter',
                'perawat' => 'Perawat',
                'manajemen' => 'Manajemen',
                'kasir' => 'Kasir',
                'farmasi' => 'Farmasi'
            ], ['class' => 'form-control']) ?>

    <!-- <br> -->
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([10 => 'Aktif', 0 => 'Tidak Aktif'], ['prompt' => 'Pilih Status Akun']) ?>


    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>