
<?php

use kartik\grid\ExpandRowColumn;
use kartik\grid\GridView;

return [
    [
        'class' => ExpandRowColumn::class,
        'value' => function () {
            return GridView::ROW_COLLAPSED;
        },
        'detail' => function ($model) {
            return Yii::$app->controller->renderPartial('_detail', [
                'model' => $model
            ]);
        },
    ],
    [
        'attribute' => 'pegawai.nama',
        'label' => 'Nama Pegawai',
        'value' => function ($model) {
            return $model['pegawai']->nama;
        }
    ],
    [
        'attribute' => 'pegawai.nip',
        'label' => 'NIP',
        'value' => function ($model) {
            return $model['pegawai']->nip;
        }
    ],

    [
        'attribute' => 'pegawai.poli_id',
        'label' => 'Poli',
        'value' => function ($model) {
            return $model['pegawai']->poli->poli;
        }
    ],
];