
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
        'detail' => function ($model) use ($groupedJadwal) {
            $pegawai_id = $model->pegawai_id;
            return Yii::$app->controller->renderPartial('_detail', [
                'model' => $groupedJadwal[$pegawai_id] ?? []
            ]);
        },
    ],
    [
        'attribute' => 'pegawai_nama',
        'label' => 'Nama Pegawai',
        'value' => function ($model) {
            return $model->pegawai->nama;
        },
        'filter' => Html::activeTextInput($searchModel, 'pegawai_nama', [
            'class' => 'form-control',
            'placeholder' => 'Cari Nama Pegawai...'
        ]),
    ],
    [
        'attribute' => 'pegawai.nip',
        'label' => 'NIP',
        'value' => function ($model) {
            return $model->pegawai->nip;
        }
    ],

    [
        'attribute' => 'pegawai.poli_id',
        'label' => 'Poli',
        'value' => function ($model) {
            return $model->pegawai->poli->poli;
        }
    ],
];
