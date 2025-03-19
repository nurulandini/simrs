<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DataResepDetail $model */

$this->title = 'Update Data Resep Detail: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Data Resep Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="data-resep-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
