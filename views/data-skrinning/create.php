<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DataSkrinning $model */

$this->title = 'Tambah Data Skrinning';
$this->params['breadcrumbs'][] = ['label' => 'Data Skrinnings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-skrinning-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>