<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DataRekamMedis $model */

$this->title = 'Update Data Rekam Medis: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Data Rekam Medis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="data-rekam-medis-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'skrinningDropdown' => $skrinningDropdown,
        'layananList' => $layananList,
        'obatList' => $obatList,
    ]) ?>

</div>