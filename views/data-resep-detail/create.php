<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DataResepDetail $model */

$this->title = 'Create Data Resep Detail';
$this->params['breadcrumbs'][] = ['label' => 'Data Resep Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-resep-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
