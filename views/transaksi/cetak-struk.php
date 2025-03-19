<?php

use yii\helpers\Html;

$this->title = "Struk Pembayaran";
?>

<div style="width: 80mm; padding: 10px; font-family: Arial, sans-serif; border: 1px solid #ddd;">
    <div style="text-align: center;">
        <h3 style="margin: 5px 0;">Klinik Dadelion</h3>
        <p style="margin: 0; font-size: 12px;">Jl. Kesehatan No. 123, Medan</p>
        <p style="margin: 0; font-size: 12px;">Telp: (061) 123456</p>
    </div>

    <hr style="border: 1px dashed #000;">

    <table style="width: 100%; font-size: 14px;">
        <tr>
            <td><strong>No. Transaksi</strong></td>
            <td style="text-align: right;"><?= $model->id ?></td>
        </tr>
        <tr>
            <td><strong>Tanggal Transaksi</strong></td>
            <td style="text-align: right;">
                <?= $model->created_at ? date('d-m-Y H:i', intval($model->created_at)) : '-' ?>
            </td>
        </tr>
        <tr>
            <td><strong>Tanggal Kunjungan</strong></td>
            <td style="text-align: right;">
                <?= isset($model->rekamMedis->skrinning->pendaftaran->created_at) && $model->rekamMedis->skrinning->pendaftaran->created_at
                    ? date('d-m-Y', intval($model->rekamMedis->skrinning->pendaftaran->created_at))
                    : '-' ?>
            </td>
        </tr>
        <tr>
            <td><strong>Nama Pasien</strong></td>
            <td style="text-align: right;"><?= $model->rekamMedis->skrinning->pendaftaran->pasien->nama ?? '-' ?></td>
        </tr>
        <tr>
            <td><strong>Poli Tujuan</strong></td>
            <td style="text-align: right;"><?= $model->rekamMedis->skrinning->pendaftaran->poli->nama_poli ?? '-' ?></td>
        </tr>
        <tr>
            <td><strong>Dokter</strong></td>
            <td style="text-align: right;"><?= $model->rekamMedis->dokter->nama ?? '-' ?></td>
        </tr>
    </table>

    <hr style="border: 1px dashed #000;">

    <!-- Detail Layanan -->
    <p style="font-weight: bold; margin: 5px 0;">Layanan:</p>
    <table style="width: 100%; font-size: 14px;">
        <?php if (!empty($model->rekamMedis->rekamMedisDetails)) : ?>
            <tr>
                <th style="text-align: left;">Layanan</th>
                <th style="text-align: right;">Biaya</th>
            </tr>
            <?php foreach ($model->rekamMedis->rekamMedisDetails as $detail) : ?>
                <tr>
                    <td><?= $detail->layanan->layanan ?? '-' ?></td>
                    <td style="text-align: right;">Rp <?= number_format($detail->biaya, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="2" style="text-align: center;">Tidak ada layanan</td>
            </tr>
        <?php endif; ?>
    </table>

    <hr style="border: 1px dashed #000;">

    <!-- Detail Obat -->
    <p style="font-weight: bold; margin: 5px 0;">Obat:</p>
    <table style="width: 100%; font-size: 14px;">
        <?php if (!empty($model->rekamMedis->dataResepDetails)) : ?>
            <tr>
                <th style="text-align: left;">Nama Obat</th>
                <th style="text-align: center;">Jumlah</th>
                <th style="text-align: center;width:20%">@</th>
                <th style="text-align: center;">Total Harga</th>
            </tr>
            <?php foreach ($model->rekamMedis->dataResepDetails as $resep) : ?>
                <tr>
                    <td><?= $resep->obat->nama ?? '-' ?></td>
                    <td style="text-align: center;"><?= $resep->jumlah ?? '0' ?></td>
                    <td style="text-align: right;">Rp <?= number_format($resep->obat->harga_per_unit, 0, ',', '.') ?></td>
                    <td style="text-align: right;">Rp <?= number_format($resep->biaya, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="3" style="text-align: center;">Tidak ada obat</td>
            </tr>
        <?php endif; ?>
    </table>

    <hr style="border: 1px dashed #000;">

    <!-- Total Pembayaran -->
    <table style="width: 100%; font-size: 14px;">
        <tr>
            <td><strong>Subtotal Layanan</strong></td>
            <td style="text-align: right;">Rp <?= number_format($model->biaya_layanan, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td><strong>Subtotal Obat</strong></td>
            <td style="text-align: right;">Rp <?= number_format($model->biaya_obat, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <hr style="border: 1px dashed #000;">
            </td>
        </tr>
        <tr>
            <td><strong>Total</strong></td>
            <td style="text-align: right; font-size: 16px; font-weight: bold;">Rp <?= number_format($model->total_harga, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td><strong>Status</strong></td>
            <td style="text-align: right; color: <?= $model->status_pembayaran == 1 ? 'green' : 'red' ?>;">
                <strong><?= $model->status_pembayaran == 1 ? 'LUNAS' : 'BELUM LUNAS' ?></strong>
            </td>
        </tr>
    </table>

    <hr style="border: 1px dashed #000;">

    <p style="text-align: center; font-size: 12px;">
        Terima kasih atas kunjungan Anda! <br>
        Semoga lekas sembuh. 😊
    </p>
</div>

<?php if ($model->status_pembayaran == 1): ?>
    <script>
        window.print(); // Cetak otomatis jika pembayaran lunas
    </script>
<?php endif; ?>