<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */


?>
<div class="gabung proyek-email">

    <p>Halo <?= Html::encode($model->perusahaan->nama_perusahaan) ?>,</p>
    <p>Perusahaan Anda berhasil didaftarkan untuk bergabung dengan proyek CSR Kota Medan !</p>
    <p>Proyek : <?= Html::encode($model->program->nama) ?></p>
    <p>Penerima : <?= Html::encode($model->program->penerima) ?></p>
    <p>Deskripsi Proyek : <?= Html::encode($model->program->deskripsi) ?></p>
    <p>Total : <?= Html::encode($model->terambil) . Html::encode($model->program->satuan) ?></p>
    <p>Anggaran : <?= Html::encode(Yii::$app->formatter->asCurrency($model->anggaran_terambil)) ?></p>
    <p>Tunggu konfirmasi selanjutnya oleh admin mengenai jadwal rapat pembahasan proyek.</p>
</div>