<?php

use yii\helpers\Html;
?>
<h2 style="text-align:center;">Laporan Transaksi</h2>
<table border="1" cellspacing="0" cellpadding="5" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Pasien</th>
            <th>Total</th>
            <th>Detail Layanan</th>
            <th>Resep Obat</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($dataProvider->models as $model): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= Yii::$app->formatter->asDate($model->created_at, 'php:d-m-Y') ?></td>
                <td><?= Html::encode($model->rekamMedis->skrinning->pendaftaran->pasien->nama) ?></td>
                <td>Rp <?= Yii::$app->formatter->asDecimal($model->total_harga, 0) ?></td>
                <td>
                    <ul>
                        <?php foreach ($model->rekamMedis->rekamMedisDetails as $layanan): ?>
                            <li><?= Html::encode($layanan->layanan->layanan) ?> - Rp <?= Yii::$app->formatter->asDecimal($layanan->biaya, 0) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php foreach ($model->rekamMedis->dataResepDetails as $resep): ?>
                            <li><?= Html::encode($resep->obat->nama) ?> - <?= $resep->jumlah ?> <?= Html::encode($resep->obat->satuan->satuan) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>