<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DataPegawai */
?>
<div class="data-pegawai-update">

    <?= $this->render('_form', [
        'model' => $model,
        'model_kecamatan' => $model_kecamatan
    ]) ?>

</div>