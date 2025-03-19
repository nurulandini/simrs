<?php

use yii\helpers\ArrayHelper;
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
        'value' => function ($model) {
            return Html::encode($model->username);
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'pegawai_id',
        'label' => 'Nama Pegawai',
        'value' => function ($model) {
            $id = $model->pegawai_id;
            if ($id != 0) {
                return $model->pegawai->nama;
            } else {
                return "-";
            }
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Peran',
        'value' => function ($model) {
            // Jika authAssignments memiliki banyak data, kita perlu memilih item_name dari koleksi
            $assignments = $model->authAssignments;
            return $assignments ? implode(', ', ArrayHelper::getColumn($assignments, 'item_name')) : 'Tidak Ada Peran';
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'email',
    ],
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
        'template' => mdm\admin\components\Helper::filterActionColumn('{view} {update} {change-password-user} {delete}'),
        'buttons' => [
            'change-password-user' => function ($url, $model) {
                return \yii\helpers\Html::a('<span class="fa fa-key"></span>', $url, [
                    'title' => Yii::t('app', 'lead-view'),
                    'role' => 'modal-remote',
                    'title' => 'Change Password',
                    'data-toggle' => 'tooltip',
                    'class' => 'btn btn-sm btn-outline-warning'
                ]);
            },
        ],
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
        'buttons' => [

            'change-password-user' => function ($url, $model) {
                return \yii\helpers\Html::a('<span class="fa fa-key"></span>', $url, [
                    'title' => Yii::t('app', 'lead-view'),
                    'role' => 'modal-remote',
                    'title' => 'Change Password',
                    'data-toggle' => 'tooltip',
                    'class' => 'btn btn-sm btn-outline-warning'
                ]);
            },
        ],
    ],

];
