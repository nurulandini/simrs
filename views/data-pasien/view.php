<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DataPasien */
?>
<div class="data-pasien-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nik',
            'nama',
            [
                'format' => 'raw',
                'attribute' => 'jenis_kelamin',
                'filter' => ['1' => 'Laki-laki', '0' => 'Perempuan'],
                'value' => function ($model) {
                    return Html::label($model->jenis_kelamin ? 'Laki - Laki' : 'Perempuan', NULL);
                },
            ],
            'tempat_lahir',
            'tanggal_lahir',
            'nomor_hp',
            [
                'attribute' => 'alamat',
                'contentOptions' => [
                    'style' => 'width:auto; white-space: normal;'
                ],
                'value' => function ($model) {
                    return $model->alamat . ', Kelurahan ' . $model->kelurahan->kelurahan . ', Kecamatan ' . $model->kelurahan->kecamatan->kecamatan;
                },
            ]
        ],
    ]) ?>

</div>