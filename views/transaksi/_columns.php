<?php

use yii\helpers\Html;
use kartik\grid\ActionColumn;
use yii\grid\SerialColumn;

return [
    ['class' => SerialColumn::class], // Nomor urut otomatis

    [
        'attribute' => 'pasien_id',
        'header' => 'Pasien',
        'value' => function ($model) {
            return $model->rekamMedis->skrinning->pendaftaran->pasien->nama ?? '-';
        },
        'filter' => \yii\helpers\Html::activeTextInput($searchModel, 'pasien_id', ['class' => 'form-control']),
        'contentOptions' => ['style' => 'width: 200px;'],
    ],


    [
        'attribute' => 'hasil_rekam_medis',
        'header' => 'Hasil Diagnosa',
        'format' => 'raw',
        'value' => function ($model) {
            return Html::decode($model->rekamMedis->diagnosa ?? '-');
        },
        'contentOptions' => ['style' => 'width: 250px;'],
    ],

    [
        'attribute' => 'layanan_medis',
        'header' => 'Layanan Medis',
        'format' => 'raw',
        'value' => function ($model) {
            $layananList = '';

            if (!empty($model->rekamMedis->rekamMedisDetails)) {
                foreach ($model->rekamMedis->rekamMedisDetails as $detail) {
                    // Cek apakah layanan tersedia
                    if (!empty($detail->layanan)) {
                        $layananList .= '<li>' . Html::encode($detail->layanan->layanan) . ' - Rp ' . number_format($detail->biaya, 0, ',', '.') . '</li>';
                    }
                }
            }

            return $layananList ? '<ul>' . $layananList . '</ul>' : '-';
        },
        'contentOptions' => ['style' => 'width: 250px;'],
    ],

    [
        'attribute' => 'resep_obat',
        'header' => 'Resep Obat',
        'format' => 'raw',
        'value' => function ($model) {
            $resepList = '';
            foreach ($model->rekamMedis->dataResepDetails as $resep) {
                $resepList .= '<li>' . $resep->obat->nama . ' - Rp ' . number_format($resep->biaya, 0, ',', '.') . '</li>';
            }
            return $resepList ? '<ul>' . $resepList . '</ul>' : '-';
        },
        'contentOptions' => ['style' => 'width: 250px;'],
    ],

    [
        'attribute' => 'total_harga',
        'header' => 'Total Harga',
        'format' => ['decimal', 0],
        'contentOptions' => ['style' => 'text-align: right; width: 150px;'],
    ],

    [
        'attribute' => 'metode_pembayaran',
        'header' => 'Metode Pembayaran',
        'value' => function ($model) {
            if ($model->metode_pembayaran == 1) {
                # code...
                return 'Tunai';
            } elseif ($model->metode_pembayaran == 2) {
                # code...
                return 'Transfer';
            } else {
                # code...
                return 'Asuransi';
            }
        },
        'filter' => [
            '1' => 'Tunai',
            '2' => 'Transfer',
            '3' => 'Asuransi',
        ],
        'contentOptions' => ['style' => 'width: 150px;'],
    ],

    [
        'attribute' => 'status_pembayaran',
        'header' => 'Status Pembayaran',
        'format' => 'raw',
        'value' => function ($model) {
            return $model->status_pembayaran == 1
                ? '<span class="badge badge-success">Lunas</span>'
                : '<span class="badge badge-danger">Belum Lunas</span>';
        },
        'filter' => [
            1 => 'Lunas',
            0 => 'Belum Lunas',
        ],
        'contentOptions' => ['style' => 'width: 150px; text-align: center;'],
    ],

    [
        'class' => ActionColumn::class,
        'header' => 'Aksi',
        'template' => '{view} {update-status}',
        'viewOptions' => ['role' => 'modal-remote', 'title' => Yii::t('yii2-ajaxcrud', 'View'), 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-success'],
        'buttons' => [
            'update-status' => function ($url, $model) {
                if ($model->status_pembayaran == 0) {
                    return Html::a(
                        '<i class="fas fa-edit"></i>',
                        ['update-status', 'id' => $model->id],
                        [
                            'class' => 'btn btn-warning btn-sm',
                            'data-confirm' => 'Yakin ingin mengubah status pembayaran?',
                            'data-method' => 'post',
                        ]
                    );
                }
                return null;
            },
        ],
        'contentOptions' => ['style' => 'width: 200px; text-align: center;'],
    ],
];
