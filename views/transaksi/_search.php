<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\TransaksiSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="transaksi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'rekam_medis_id') ?>

    <?= $form->field($model, 'biaya_layanan') ?>

    <?= $form->field($model, 'biaya_obat') ?>

    <?= $form->field($model, 'total_harga') ?>

    <?php // echo $form->field($model, 'status_pembayaran') 
    ?>

    <?php // echo $form->field($model, 'metode_pembayaran') 
    ?>

    <?php // echo $form->field($model, 'asuransi') 
    ?>

    <?php // echo $form->field($model, 'created_at') 
    ?>

    <?php // echo $form->field($model, 'updated_at') 
    ?>

    <?php // echo $form->field($model, 'created_by') 
    ?>

    <?php // echo $form->field($model, 'updated_by') 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>