<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\DataObatSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="data-obat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nama') ?>

    <?= $form->field($model, 'kategori_id') ?>

    <?= $form->field($model, 'deskripsi') ?>

    <?= $form->field($model, 'tanggal_kedaluwarsa') ?>

    <?php // echo $form->field($model, 'persediaan') ?>

    <?php // echo $form->field($model, 'satuan_id') ?>

    <?php // echo $form->field($model, 'harga_per_unit') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
