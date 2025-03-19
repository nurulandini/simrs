Halo <?= $model->transaksi->perusahaan->nama_perusahaan ?>
Kami ingin menginformasikan bahwa kegiatan CSR di bawah: 
Proyek : <?= $model->transaksi->program->nama ?>
Penerima : <?= $model->transaksi->program->penerima ?>
Deskripsi Proyek : <?= $model->transaksi->program->deskripsi ?>
Total : <?= $model->transaksi->terambil." " . $model->transaksi->program->satuan ?>
Total Anggaran : <?= Yii::$app->formatter->asCurrency($model->transaksi->program->anggaran) ?>

Telah direalisasikan pada Tanggal <?= Yii::$app->formatter->asDate($model->tanggal_realisasi, 'php:d-M-Y')?> .