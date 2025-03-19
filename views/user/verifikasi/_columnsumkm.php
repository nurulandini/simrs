<?php

use yii\helpers\Html;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'username',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'email',
    ],

    // [
    //     'class' => '\kartik\grid\DataColumn',
    //     'attribute' => 'perusahaan_id',
    //     'value' => function ($model) {  
    //         if ($model->perusahaan_id) {
    //             return $model->perusahaan->nama;
    //         }
    //     }
    // ],
    // [
    //     'class' => '\kartik\grid\DataColumn',
    //     'attribute' => 'lsm_id',
    //     'value' => function ($model) {
    //         $id = $model->lsm_id;
    //         if ($id != 0) {
    //             return $model->lsm->nama;
    //         }
    //     }
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'masyarakat_id',
        'value' => function ($model) {
            $id = $model->masyarakat_id;
            if ($id != 0) {
                return $model->masyarakat->nama;
            } else {
                return "-";
            }
        }
    ],
    // [
    //     'class' => '\kartik\grid\DataColumn',
    //     'attribute' => 'subunit_id',
    //     'value' => function ($model) {
    //         $id = $model->subunit_id;
    //         if ($id != 0) {
    //             return $model->subUnit->sub_unit;
    //         } else {
    //             return "-";
    //         }
    //     }
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'format' => 'raw',
        'attribute' => 'status',
        'headerOptions' => [
            'style' => 'text-align : center'
        ],
        'contentOptions' => [
            'style' => 'width:auto; white-space: normal; text-align : center'
        ],
        'filter' => ['10' => 'AKTIF', '0' => 'NONAKTIF'],
        'value' => function ($model) {
            return Html::label($model->status ? 'AKTIF' : 'NONAKTIF', NULL, ['class' => 'badge badge-' . ($model->status ? 'success' : 'danger')]);
        },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'noWrap' => 'true',
        'template' => mdm\admin\components\Helper::filterActionColumn('{verifikasi-user}'),
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'buttons' => [
            'verifikasi-user' => function ($url, $model) {
                if ($model->status == 0) {
                    return \yii\helpers\Html::a('<span class="fa fa-check-circle"></span>', $url, ['role' => 'modal-remote', 'title' => 'Verifikasi User', 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-success']);
                } else {
                    return \yii\helpers\Html::a('<span class="fa fa-ban"></span>', $url, ['role' => 'modal-remote', 'title' => 'Ubah Status', 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-danger']);
                }
            },
            // 'change-password-user' => function ($url, $model) {
            //     return \yii\helpers\Html::a('<span class="fa fa-key"></span>', $url, [
            //         'title' => Yii::t('app', 'lead-view'), 'role' => 'modal-remote', 'title' => 'Change Password', 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-warning'
            //     ]);
            // },
        ],
    ],

];
