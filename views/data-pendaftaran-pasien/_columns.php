<?php

use yii\helpers\Html;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'id',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nama_pasien',
        'label' => 'Pasien',
        'value' => function ($model) {
            return $model->pasien->nama;
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'pegawai_nama',
        'label' => 'Dokter',
        'value' => function ($model) {
            return $model->pegawai->nama;
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'Poli',
        'label' => 'Poli',
        'value' => function ($model) {
            return $model->pegawai->poli->poli;
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
        'template' => '{view} {update} {delete}', 
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
                        'data-method' => false, 
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
