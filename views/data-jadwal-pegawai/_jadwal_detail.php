<?php

use kartik\grid\GridView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'hari_kerja',
            'value' => function ($model) {
                $hariList = [
                    1 => 'Senin',
                    2 => 'Selasa',
                    3 => 'Rabu',
                    4 => 'Kamis',
                    5 => 'Jumat',
                    6 => 'Sabtu',
                    7 => 'Minggu',
                ];
                return $hariList[$model->hari_kerja] ?? '-';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'shift',
            'value' => function ($model) {
                $shiftList = [
                    1 => 'Pagi (07:00 - 15:00)',
                    2 => 'Siang (15:00 - 23:00)',
                    3 => 'Malam (23:00 - 07:00)',
                ];
                return $shiftList[$model->shift] ?? '-';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'mulai',
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'akhir',
        ],
    ],
]);
