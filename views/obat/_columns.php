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
        'attribute' => 'nama',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'kategori_id',
        'label' => 'Kategori',
        'value' => function ($model) {
            return $model->kategori->kategori;
        },
        'filter' => \yii\helpers\ArrayHelper::map(\app\models\KategoriObat::find()->all(), 'id', 'kategori'),
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'deskripsi',
        'filter' => false
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'tanggal_kedaluwarsa',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'persediaan',
        'format' => ['decimal', 0],
        'filter' => Html::activeDropDownList(
            $searchModel,
            'persediaan_sort',
            [
                'asc' => 'Paling Sedikit',
                'desc' => 'Paling Banyak',
            ],
            ['class' => 'form-control', 'prompt' => 'Urutkan']
        ),
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'satuan_id',
        'label' => 'Satuan',
        'value' => function ($model) {
            return $model->satuan->satuan;
        },
        'filter' => false
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'format' => 'raw',
        'label' => 'Harga Per Unit',
        'attribute' => 'harga_per_unit',
        'value' => function ($model) {
            return 'Rp. ' . number_format($model->harga_per_unit, 0, ",", ".");
        },
        'filter' => false

    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'noWrap' => 'true',
        'template' => mdm\admin\components\Helper::filterActionColumn('{view} {update} {delete}'),
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
