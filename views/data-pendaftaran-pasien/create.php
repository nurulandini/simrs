<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DataPendaftaranPasien $model */

$this->title = 'Create Data Pendaftaran Pasien';
$this->params['breadcrumbs'][] = ['label' => 'Data Pendaftaran Pasiens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-pendaftaran-pasien-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_poli' => $model_poli
    ]) ?>

</div>