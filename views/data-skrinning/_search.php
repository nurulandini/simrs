<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\DataSkrinningSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="data-skrinning-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pendaftaran_id') ?>

    <?= $form->field($model, 'pegawai_id') ?>

    <?= $form->field($model, 'tinggi') ?>

    <?= $form->field($model, 'berat') ?>

    <?php // echo $form->field($model, 'tekanan_darah') 
    ?>

    <?php // echo $form->field($model, 'suhu') 
    ?>

    <?php // echo $form->field($model, 'denyut_jantung') 
    ?>

    <?php // echo $form->field($model, 'saturasi_oksigen') 
    ?>

    <?php // echo $form->field($model, 'catatan') 
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