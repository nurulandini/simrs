<?php

use yii\helpers\Html;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
        'headerOptions' => [
            'style' => 'vertical-align: top;'
        ],
        'contentOptions' => [
            'style' => 'vertical-align: top !important;'
        ],
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
        'headerOptions' => [
            'style' => 'vertical-align: top;'
        ],
        'contentOptions' => [
            'style' => 'vertical-align: top !important;'
        ],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nama_pasien',
        'contentOptions' => [
            'style' => 'width:auto; white-space: normal;'
        ],
        'label' => 'Nama Pasien',
        'value' => function ($model) {
            return $model->skrinning->pendaftaran->pasien->nama ?? '-';
        },
        'filter' => Html::activeTextInput($searchModel, 'nama_pasien', [
            'class' => 'form-control',
            'placeholder' => 'Cari Nama Pasien...'
        ]),
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Tanggal Rekam Medis',
        'format' => ['date', 'php:d-m-Y'], // Format: DD-MM-YYYY HH:MM:SS
        'value' => function ($model) {
            return $model->created_at;
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'diagnosa',
        'format' => 'raw',
        'value' => function ($model) {
            return Html::decode($model->diagnosa);
        },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'noWrap' => true,
        'headerOptions' => [
            'style' => 'vertical-align: top;'
        ],
        'contentOptions' => [
            'style' => 'vertical-align: top !important;'
        ],
        'template' => '{view} {update} {delete}', // Default semua tombol tampil
        'buttons' => [
            'update' => function ($url, $model, $key) {
                return $model->status == 0 ? '' :
                    Html::a('<i class="fas fa-edit"></i>', $url, [
                        'role' => 'modal-remote',
                        'title' => Yii::t('yii2-ajaxcrud', 'Update'),
                        'data-toggle' => 'tooltip',
                        'class' => 'btn btn-sm btn-outline-primary'
                    ]);
            },
            'delete' => function ($url, $model, $key) {
                return $model->status == 0 ? '' :
                    Html::a('<i class="fas fa-trash"></i>', $url, [
                        'role' => 'modal-remote',
                        'title' => Yii::t('yii2-ajaxcrud', 'Delete'),
                        'class' => 'btn btn-sm btn-outline-danger',
                        'data-confirm' => false,
                        'data-method' => false, // Override Yii data API
                        'data-request-method' => 'post',
                        'data-toggle' => 'tooltip',
                        'data-confirm-title' => Yii::t('yii2-ajaxcrud', 'Delete'),
                        'data-confirm-message' => Yii::t('yii2-ajaxcrud', 'Delete Confirm'),
                    ]);
            },
        ],
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'viewOptions' => [
            'role' => 'modal-remote',
            'title' => Yii::t('yii2-ajaxcrud', 'View'),
            'data-toggle' => 'tooltip',
            'class' => 'btn btn-sm btn-outline-success'
        ],
    ],

];
