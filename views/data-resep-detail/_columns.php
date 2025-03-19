<?php

use kartik\grid\ExpandRowColumn;
use kartik\grid\GridView;
use yii\helpers\Html;

return [
    [
        'class' => ExpandRowColumn::class,
        'value' => function () {
            return GridView::ROW_COLLAPSED;
        },
        'detail' => function ($model) use ($groupedResep) {
            $rekam_medis_id = $model->rekam_medis_id;
            return Yii::$app->controller->renderPartial('_detail', [
                'model' => $groupedResep[$rekam_medis_id] ?? []
            ]);
        },
    ],
    [
        'attribute' => 'nama_pasien',
        'label' => 'Nama Pasien',
        'value' => function ($model) {
            return $model->rekamMedis->skrinning->pendaftaran->pasien->nama ?? '-';
        },
        'filter' => Html::activeTextInput($searchModel, 'nama_pasien', [
            'class' => 'form-control',
            'placeholder' => 'Cari Nama Pasien...'
        ]),
    ],
    [
        'label' => 'Dokter',
        'value' => function ($model) {
            return $model->rekamMedis->skrinning->pendaftaran->pegawai->nama ?? '-';
        }
    ],

    [
        'label' => 'Poli',
        'value' => function ($model) {
            return $model->rekamMedis->skrinning->pendaftaran->pegawai->poli->poli ?? '-';
        }
    ],
];
