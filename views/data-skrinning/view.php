<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\DataSkrinning $model */

// $this->title = $model->pendaftaran->pasien->nama;
$this->params['breadcrumbs'][] = ['label' => 'Data Skrinnings', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="data-skrinning-view">

    <h1>Hasil Skrinning Pasien</h1>

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
                'attribute' => 'pendaftaran_id',
                'contentOptions' => [
                    'style' => 'width:auto; white-space: normal;'
                ],
                'label' => 'Nama Pasien',
                'value' => function ($model) {
                    return $model->pendaftaran->pasien->nama;
                },
            ],
            [
                'attribute' => 'pendaftaran_id',
                'contentOptions' => [
                    'style' => 'width:auto; white-space: normal;'
                ],
                'label' => 'Jenis Kelamin',
                'value' => function ($model) {
                    $jk = $model->pendaftaran->pasien->jenis_kelamin;
                    if ($jk == 1) {
                        # code...
                        return 'Laki - Laki';
                    } else {
                        return 'Perempuan';
                    }
                },
            ],
            [
                'attribute' => 'pendaftaran_id',
                'contentOptions' => [
                    'style' => 'width:auto; white-space: normal;'
                ],
                'label' => 'Tempat / Tanggal Lahir',
                'value' => function ($model) {
                    return $model->pendaftaran->pasien->tempat_lahir . ', ' . Yii::$app->formatter->asDate($model->pendaftaran->pasien->tanggal_lahir, 'php:d-m-y');
                },
            ],
            [
                'attribute' => 'pegawai_id',
                'contentOptions' => [
                    'style' => 'width:auto; white-space: normal;'
                ],
                'label' => 'Perawat Yang Melakukan Skrinning',
                'value' => function ($model) {
                    return $model->pegawai->nama . ' ( Perawat  ' . $model->pegawai->poli->poli . ' )';
                },
            ],
            [
                'attribute' => 'tinggi',
                'contentOptions' => [
                    'style' => 'width:auto; white-space: normal;'
                ],
                'label' => 'Tinggi Badan',
                'value' => function ($model) {
                    return $model->tinggi . ' cm';
                },
            ],
            [
                'attribute' => 'berat',
                'contentOptions' => [
                    'style' => 'width:auto; white-space: normal;'
                ],
                'label' => 'Berat Badan',
                'value' => function ($model) {
                    return $model->berat. ' kg';
                },
            ],
            [
                'attribute' => 'tekanan_darah',
                'contentOptions' => [
                    'style' => 'width:auto; white-space: normal;'
                ],
                'label' => 'Tekanan Darah',
                'value' => function ($model) {
                    return $model->tekanan_darah;
                },
            ],
            [
                'attribute' => 'suhu',
                'contentOptions' => [
                    'style' => 'width:auto; white-space: normal;'
                ],
                'label' => 'Suhu Badan',
                'value' => function ($model) {
                    return $model->suhu. ' °C';
                },
            ],
            [
                'attribute' => 'denyut_jantung',
                'contentOptions' => [
                    'style' => 'width:auto; white-space: normal;'
                ],
                'label' => 'Denyut Jantung',
                'value' => function ($model) {
                    return $model->denyut_jantung. ' bpm';
                },
            ],
            [
                'attribute' => 'saturasi_okksigen',
                'contentOptions' => [
                    'style' => 'width:auto; white-space: normal;'
                ],
                'label' => 'Saturasi Oksigen',
                'value' => function ($model) {
                    return $model->saturasi_oksigen. ' %';
                },
            ],
            [
                'attribute' => 'catatan',
                'contentOptions' => [
                    'style' => 'width:auto; white-space: normal;'
                ],
                'label' => 'Catatan Medis',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::decode($model->catatan);
                },
            ],
        ],
    ]) ?>

</div>