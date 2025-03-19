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
        'attribute' => 'nik',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nama',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'format' => 'raw',
        'attribute' => 'jenis_kelamin',
        'filter' => ['1' => 'Laki-laki', '0' => 'Perempuan'],
        'value' => function ($model) {
            return Html::label($model->jenis_kelamin ? 'Laki - Laki' : 'Perempuan', NULL);
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'tempat_lahir',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'tanggal_lahir',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nomor_hp',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'alamat',
        'contentOptions' => [
            'style' => 'width:auto; white-space: normal;'
        ],
        'value' => function ($model) {
            return $model->alamat . ', Kelurahan ' . $model->kelurahan->kelurahan . ', Kecamatan ' . $model->kelurahan->kecamatan->kecamatan;
        },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'noWrap' => 'true',
        'template' => '{view} {update} {delete}',
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'viewOptions' => ['role' => 'modal-remote', 'title' => Yii::t('yii2-ajaxcrud', 'View'), 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-success'],
        'updateOptions' => ['role' => 'modal-remote', 'title' => Yii::t('yii2-ajaxcrud', 'Update'), 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-primary'],
        'deleteOptions' => [
            'role' => 'modal-remote',
            'title' => Yii::t('yii2-ajaxcrud', 'Delete'),
            'class' => 'btn btn-sm btn-outline-danger',
            'data-confirm' => false,
            'data-method' => false, // for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => Yii::t('yii2-ajaxcrud', 'Delete'),
            'data-confirm-message' => Yii::t('yii2-ajaxcrud', 'Delete Confirm')
        ],
    ],

];
