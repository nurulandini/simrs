<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DataPendaftaranPasien $model */

$this->title = 'Update Data Pendaftaran Pasien: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Data Pendaftaran Pasiens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="data-pendaftaran-pasien-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_poli' => $model_poli,
    ]) ?>

</div>