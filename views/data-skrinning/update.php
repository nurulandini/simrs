<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DataSkrinning $model */

$this->title = 'Update Data Skrinning: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Data Skrinnings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="data-skrinning-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'pendaftaranData' => $pendaftaranData
    ]) ?>

</div>