<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DataRekamMedis $model */

$this->title = 'Create Data Rekam Medis';
$this->params['breadcrumbs'][] = ['label' => 'Data Rekam Medis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-rekam-medis-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'skrinningDropdown' => $skrinningDropdown,
        'layananList' => $layananList,
        'obatList' => $obatList,
    ]) ?>

</div>