<?php

use app\models\RekamMedisDetail;
use yii\helpers\Html;
use yii\widgets\DetailView;
use Carbon\Carbon; // Gunakan Carbon untuk menghitung umur

/** @var yii\web\View $this */
/** @var app\models\DataRekamMedis $model */
/** @var app\models\RekamMedisDetail[] $layananDetails */
/** @var app\models\DataResepDetail[] $resepDetails */
/** @var app\models\DataSkrinning $skrinning */
/** @var app\models\DataPasien $pasien */

// Ambil data pasien dari skrining
$pasien = $model->skrinning->pendaftaran->pasien;

$layananDetails = RekamMedisDetail::find()->where(['rekam_medis_id' => $model->id])->all();

// Fungsi untuk menghitung umur detail hingga bulan
function hitungUmur($tanggal_lahir)
{
    $birthDate = new DateTime($tanggal_lahir);
    $today = new DateTime(); // Tanggal sekarang
    $diff = $today->diff($birthDate);

    return "{$diff->y} tahun, {$diff->m} bulan";
}

$this->title = "Detail Rekam Medis - " . $pasien->nama;
$this->params['breadcrumbs'][] = ['label' => 'Rekam Medis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="data-rekam-medis-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apakah Anda yakin ingin menghapus data ini?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <h2>Data Pasien</h2>
    <?= DetailView::widget([
        'model' => $pasien,
        'attributes' => [
            'nama',
            [
                'attribute' => 'jenis_kelamin',
                'value' => function ($model) {
                    $jk = $model->jenis_kelamin;
                    if ($jk == 1) {
                        # code...
                        return 'Laki - Laki';
                    } else {
                        return 'Perempuan';
                    }
                },
            ],
            'tempat_lahir',
            [
                'label' => 'Tanggal Lahir',
                'value' => Yii::$app->formatter->asDate($pasien->tanggal_lahir, 'long'),
            ],
            [
                'label' => 'Umur',
                'value' => function ($model) {
                    return hitungUmur($model->tanggal_lahir);
                },
            ],
        ],
    ]) ?>

    <h2>Data Skrining</h2>
    <?= DetailView::widget([
        'model' => $model->skrinning,
        'attributes' => [
            [
                'attribute' => 'tinggi',
                'value' => function ($model) {
                    return $model->tinggi . ' cm';
                },
            ],
            [
                'attribute' => 'berat',
                'value' => function ($model) {
                    return $model->berat . ' kg';
                },
            ],
            [
                'attribute' => 'tekanan_darah',
                'value' => function ($model) {
                    return $model->tekanan_darah . ' mmHg';
                },
            ],
            [
                'attribute' => 'suhu',
                'value' => function ($model) {
                    return $model->suhu . ' °C';
                },
            ],
            [
                'attribute' => 'catatan',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::decode($model->catatan);
                },
            ],
        ],
    ]) ?>

    <h2>Data Rekam Medis</h2>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'created_at',
                'label' => 'Tanggal Rekam Medis',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at, 'php:d-m-Y');
                },
            ],
            [
                'attribute' => 'catatan',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::decode($model->diagnosa);
                },
            ],
            [
                'attribute' => 'catatan',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::decode($model->catatan);
                },
            ],
        ],
    ]) ?>

    <h2>Detail Layanan Medis</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Layanan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($layananMedis as $index => $layanan): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $layanan->layanan->layanan ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Detail Resep Obat</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Dosis</th>
                <th>Instruksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resepObat as $index => $resep): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $resep->obat->nama ?></td>
                    <td><?= $resep->jumlah ?> <?= $resep->obat->satuan->satuan?></td>
                    <td><?= $resep->dosis ?></td>
                    <td><?= $resep->instruksi ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>