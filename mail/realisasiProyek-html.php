<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */


?>
<div class="gabung proyek-email">

    <p>Halo <?= Html::encode($model->transaksi->perusahaan->nama_perusahaan) ?>,</p>
    <p>Perusahaan Anda berhasil didaftarkan untuk bergabung dengan proyek CSR Kota Medan !</p>
    <p>Proyek : <?= Html::encode($model->transaksi->program->nama) ?></p>
    <p>Penerima : <?= Html::encode($model->transaksi->program->penerima) ?></p>
    <p>Deskripsi Proyek : <?= Html::encode($model->transaksi->program->deskripsi) ?></p>
    <p>Total : <?= Html::encode($model->transaksi->terambil) . " " . Html::encode($model->transaksi->program->satuan) ?></p>
    <p>Total Anggaran : <?= Html::encode(Yii::$app->formatter->asCurrency($model->transaksi->anggaran_terambil)) ?></p>
    <p>Telah direalisasikan pada Tanggal <?= Html::encode(Yii::$app->formatter->asDate($model->tanggal_realisasi, 'php:d-M-Y')) ?></p>
</div>