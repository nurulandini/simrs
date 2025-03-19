<?php

use kartik\number\NumberControl;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LayananMedis */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="layanan-medis-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'layanan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deskripsi')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'biaya')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false,
                        'digits' => 1000,
                    ],
                    'displayOptions' => ['class' => 'form-control kv-monospace'],
                ]) ?>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>