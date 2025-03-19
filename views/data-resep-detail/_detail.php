<?php

use yii\helpers\Html;

?>

<p>Detail Resep</p>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Obat</th>
            <th>Dosis</th>
            <th>Jumlah</th>
            <th>Biaya</th>
            <th>Status</th>
            <th>Tanggal Penebusan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model['resep'] as $resep): ?>
            <tr>
                <td><?= $resep['nama_obat'] ?? '-' ?></td>
                <td><?= $resep['dosis'] ?? '-' ?></td>
                <td><?= $resep['jumlah'] ?? '-' ?></td>
                <td><?= Yii::$app->formatter->asCurrency($resep['biaya'] ?? 0) ?></td>
                <td>
                    <?= Html::tag('span', $resep['status'] == 1 ? 'Dikonfirmasi' : 'Belum Dikonfirmasi', [
                        'class' => $resep['status'] == 1 ? 'badge badge-success' : 'badge badge-warning'
                    ]) ?>
                </td>
                <td>
                    
                    <?php if ($resep['status'] == 0): ?>
                        <?= Html::a('Konfirmasi Tebus Resep', ['konfirmasi', 'id' => $resep['id']], [
                            'class' => 'btn btn-sm btn-success',
                            'data-confirm' => 'Apakah Anda yakin ingin mengkonfirmasi tebusan resep ini?',
                            'data-method' => 'post',
                        ]) ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>