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
            return $model->pendaftaran->pasien->nama ?? '-';
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'contentOptions' => [
            'style' => 'width:auto; white-space: normal;'
        ],
        'label' => 'Perawat Yang Melakukan Skrinning',
        'value' => function ($model) {
            return $model->pegawai->nama . ' ( Perawat  ' . $model->pegawai->poli->poli . ' )';
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'contentOptions' => [
            'style' => 'width:auto; white-space: normal;'
        ],
        'format' => 'raw',
        'label' => 'Hasil Skrinning',
        'value' => function ($model) {
            return '<table style="width:100%;background: none">
                <tr style="background: none;border:none"><td style="background: none; border:none"><b>Tinggi Badan</b></td><td>: ' . $model->tinggi . ' cm</td></tr>
                <tr style="background: none;border:none"><td style="background: none; border:none"><b>Berat Badan</b></td><td>: ' . $model->berat . ' kg</td></tr>
                <tr style="background: none;border:none"><td style="background: none; border:none"><b>Tekanan Darah</b></td><td>: ' . $model->tekanan_darah . ' cm</td></tr>
                <tr style="background: none;border:none"><td style="background: none; border:none"><b>Suhu Badan</b></td><td>: ' . $model->suhu . ' °C</td></tr>
                <tr style="background: none;border:none"><td style="background: none; border:none"><b>Denyut Jantung</b></td><td>: ' . $model->denyut_jantung . ' bpm</td></tr>
                <tr style="background: none;border:none"><td style="background: none; border:none"><b>Saturasi Oksigen</b></td><td>: ' . $model->saturasi_oksigen . ' %</td></tr>
                <tr style="background: none;border:none"><td style="background: none; border:none"><b>Catatan Medis</b></td><td>: ' . \yii\helpers\Html::decode($model->catatan) . '</td></tr>
            </table>';
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Tanggal Skrinning',// Format: DD-MM-YYYY HH:MM:SS
        'value' => function ($model) {
            return  Yii::$app->formatter->asDatetime($model->created_at, 'php:d F Y') ;
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
