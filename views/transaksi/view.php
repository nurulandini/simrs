<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Transaksi $model */

$this->title = 'Detail Transaksi ' . $model->rekamMedis->skrinning->pendaftaran->pasien->nama;
$this->params['breadcrumbs'][] = ['label' => 'Transaksi', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<?php if ($model->status_pembayaran == 1): // Jika pembayaran lunas 
?>
    <p>
        <?= Html::a('Cetak Struk', ['cetak-struk', 'id' => $model->id], [
            'class' => 'btn btn-success',
            'target' => '_blank', // Membuka di tab baru
        ]) ?>
    </p>
<?php endif; ?>
<div class="transaksi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a('<i class="fa fa-arrow-left" aria-hidden="true"></i>', ['index'], ['class' => 'btn', 'style' => 'margin-bottom:10px']) ?>
    <?php if ($model->status_pembayaran != 1): // Jika belum lunas, tampilkan tombol 
    ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-warning', 'style' => 'margin-bottom:10px']) ?>
    <?php endif; ?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'pasien_id',
                'label' => 'Nama Pasien',
                'value' => function ($model) {
                    return $model->rekamMedis->skrinning->pendaftaran->pasien->nama ?? '-';
                },
            ],
            [
                'attribute' => 'rekam_medis_id',
                'label' => 'Diagnosa',
                'format' => 'raw',
                'value' => function ($model) {
                    return html::decode($model->rekamMedis->diagnosa ?? '-');
                },
            ],
            [
                'attribute' => 'nama_layanan',
                'label' => 'Layanan',
                'value' => function ($model) {
                    $layananList = array_map(function ($detail) {
                        return $detail->layanan->layanan ?? '-';
                    }, $model->rekamMedis->rekamMedisDetails);
                    return !empty($layananList) ? implode(', ', $layananList) : '-';
                },
            ],
            [
                'attribute' => 'total_harga',
                'label' => 'Total Biaya',
                'value' => function ($model) {
                    return 'Rp ' . number_format($model->total_harga, 0, ',', '.');
                },
            ],
            [
                'attribute' => 'status_pembayaran',
                'label' => 'Status Pembayaran',
                'value' => function ($model) {
                    return $model->status_pembayaran == 1 ? 'Lunas' : 'Belum Lunas';
                },
            ],
            [
                'attribute' => 'metode_pembayaran',
                'label' => 'Metode Pembayaran',
                'value' => function ($model) {
                    return $model->metode_pembayaran == 1 ? 'Tunai' : 'Asuransi';
                },
            ],
            [
                'attribute' => 'biaya_layanan',
                'label' => 'Biaya Layanan',
                'value' => function ($model) {
                    return 'Rp ' . number_format($model->biaya_layanan, 0, ',', '.');
                },
            ],
            [
                'attribute' => 'biaya_obat',
                'label' => 'Biaya Obat',
                'value' => function ($model) {
                    return 'Rp ' . number_format($model->biaya_obat, 0, ',', '.');
                },
            ],
            [
                'attribute' => 'resep_obat',
                'label' => 'Resep Obat',
                'format' => 'raw',
                'value' => function ($model) {
                    $resepList = array_map(function ($detail) {
                        return $detail->obat->nama . ' (' . $detail->jumlah . ')';
                    }, $model->rekamMedis->dataResepDetails);
                    return !empty($resepList) ? implode(', ', $resepList) : '-';
                },
            ],
        ],
    ]) ?>

</div>