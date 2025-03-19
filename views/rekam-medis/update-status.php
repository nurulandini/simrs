<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Transaksi $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="transaksi-update-status">

    <h3>Update Status Pembayaran</h3>
    <p>Pastikan transaksi ini sudah benar sebelum memperbarui status pembayaran.</p>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'metode_pembayaran')->dropDownList([
        '1' => 'Tunai',
        '2' => 'Transfer',
        '3' => 'Asuransi'
    ], ['prompt' => 'Pilih Metode Pembayaran']) ?>

    <div class="form-group">
        <?= Html::submitButton('Set Lunas', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>