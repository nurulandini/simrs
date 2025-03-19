<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DataJadwalPegawai */
?>
<div class="data-jadwal-pegawai-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'pegawai_id',
                'contentOptions' => [
                    'style' => 'width:auto; white-space: normal;'
                ],
                'label' => 'Poli',
                'value' => function ($model) {
                    return $model->pegawai->nama;
                },
            ],
            [
                'attribute' => 'hari_kerja',
                'contentOptions' => [
                    'style' => 'width:auto; white-space: normal;'
                ],
                'label' => 'Hari Kerja',
                'value' => function ($model) {
                    if ($model->hari_kerja == 1) {
                        return 'Senin';
                    }elseif ($model->hari_kerja == 2) {
                        return 'Selasa';
                    }elseif ($model->hari_kerja == 3) {
                        return 'Rabu';
                    }elseif ($model->hari_kerja == 4) {
                        return 'Kamis';
                    }elseif ($model->hari_kerja == 5) {
                        return 'Jumat';
                    }elseif ($model->hari_kerja == 6) {
                        return 'Sabtu';
                    }else{
                        return 'Minggu';
                    }
                    
                },
            ],
            [
                'attribute' => 'shift',
                'contentOptions' => [
                    'style' => 'width:auto; white-space: normal;'
                ],
                'label' => 'Shift',
                'value' => function ($model) {
                    if ($model->hari_kerja == 1) {
                        return 'Pagi';
                    }else{
                        return 'Sore';
                    }
                    
                },
            ],
            'mulai',
            'akhir',
        ],
    ]) ?>

</div>