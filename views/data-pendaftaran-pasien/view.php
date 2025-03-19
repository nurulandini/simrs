<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\DataPendaftaranPasien $model */


$this->params['breadcrumbs'][] = ['label' => 'Data Pendaftaran Pasien', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->pasien->nama;
\yii\web\YiiAsset::register($this);
?>
<div class="data-pendaftaran-pasien-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'tanggal_kunjungan',
                'label' => 'Tanggal Kunjungan',
            ],
            [
                'attribute' => 'pegawai_id',
                'label' => 'Dokter',
                'value' => function ($model) {
                    return $model->pegawai->nama;
                },
            ],
            [
                'attribute' => 'pasien_id',
                'label' => 'Pasien',
                'value' => function ($model) {
                    return $model->pasien->nama;
                },
            ],
            [
                'attribute' => 'pegawai.poli_id',
                'label' => 'Poli',
                'value' => function ($model) {
                    return $model->pegawai->poli->poli;
                },
            ],
        ],
    ]) ?>

</div>