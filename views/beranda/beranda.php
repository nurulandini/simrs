<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

$this->title = 'Dashboard Klinik';
$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js', [
    'depends' => [\yii\web\JqueryAsset::class]
]);
?>

<div class="container mt-4" style="padding-bottom: 100px;">
    <h3 class="mb-4 font-weight-bold text-primary">
        <i class="fas fa-hospital"></i> Dashboard Klinik
    </h3>

    <!-- Cards Total Data -->
    <div class="row">
        <div class="col-md-3 mb-3">
            <center>
                <div class="card shadow-sm border-0 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <img src="<?= yii\helpers\Url::to('@web/img/uang.png') ?>" style="width: 15%;">
                        <div class="flex-grow-1">
                            <p class="text-dark fw-bold mb-0" style="font-size: 22px;">Rp. <?= $totaltransaksihariini == 0 ? 0 : number_format($totaltransaksihariini, 0, ',', '.') ?> </p>
                            <p class="text-muted mb-0" style="font-size: 1rem;">Transaksi Hari Ini</p>
                        </div>
                    </div>
                </div>
            </center>
        </div>

        <div class="col-md-3 mb-3">
            <center>
                <div class="card shadow-sm border-0 p-4" style="background-color:#8b9ea4">
                    <div class="d-flex align-items-center gap-3">
                        <img src="<?= yii\helpers\Url::to('@web/img/uang.png') ?>" style="width: 15%;">
                        <div class="flex-grow-1">
                            <p class="text-light fw-bold mb-0" style="font-size: 22px;">Rp. <?= $totaltransaksibulanini == 0 ? 0 : number_format($totaltransaksibulanini, 0, ',', '.') ?></p>
                            <p class="text-light mb-0" style="font-size: 1rem;">Transaksi Bulan Ini</p>
                        </div>
                    </div>
                </div>
            </center>
        </div>

        <div class="col-md-3 mb-3">
            <center>
                <div class="card shadow-sm border-0 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <img src="<?= yii\helpers\Url::to('@web/img/pasien.png') ?>" style="width: 22%;">
                        <div class="flex-grow-1">
                            <h2 class="text-dark fw-bold mb-0"><?= $totalpengunjunghariini == 0 ? 0 : $totalpengunjunghariini ?></h2>
                            <h4 class="text-muted mb-0" style="font-size: 1rem;">Total Pasien Hari Ini</h4>
                        </div>
                    </div>
                </div>
            </center>
        </div>
        <div class="col-md-3 mb-3">
            <center>
                <div class="card shadow-sm border-0 p-4" style="background-color:#8b9ea4">
                    <div class="d-flex align-items-center gap-3">
                        <img src="<?= yii\helpers\Url::to('@web/img/pasien.png') ?>" style="width: 22%;">
                        <div class="flex-grow-1">
                            <h2 class="text-light fw-bold mb-0"><?= $total_pengunjung == 0 ? 0 : $total_pengunjung ?></h2>
                            <h4 class="text-light mb-0" style="font-size: 1rem;">Total Pasien Bulan Ini</h4>
                        </div>
                    </div>
                </div>
            </center>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <center>
                <div class="card shadow-sm border-0 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <img src="<?= yii\helpers\Url::to('@web/img/uang.png') ?>" style="width: 18%;">
                        <div class="flex-grow-1">
                            <h2 class="text-dark fw-bold mb-0">Rp. <?= $totaltransaksi == 0 ? 0 : number_format($totaltransaksi, 0, ',', '.') ?></h2>
                            <h4 class="text-mute mb-0" style="font-size: 1rem;">Total Transaksi</h4>
                        </div>
                    </div>
                </div>
            </center>
        </div>

        <div class="col-md-6 mb-3">
            <center>
                <div class="card shadow-sm border-0 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <img src="<?= yii\helpers\Url::to('@web/img/pasien.png') ?>" style="width: 18%;">
                        <div class="flex-grow-1">
                            <h2 class="text-dark fw-bold mb-0"><?= $total_pengunjung_keseluruhan == 0 ? 0 : $total_pengunjung_keseluruhan ?></h2>
                            <h4 class="text-mute mb-0" style="font-size: 1rem;">Total Pasien Keseluruhan</h4>
                        </div>
                    </div>
                </div>
            </center>
        </div>
    </div>





    <div class="row">
        <div class="col-12 col-md-12 mb-3">
            <div class="card">
                <div class="card-header" style="background-color: #468eae;">
                    <h4 style="font-size: 22px;text-align:center;color: white;">Grafik Kunjungan Pasien Per Bulan</h4>
                </div>
                <div class="card-body bg-white">
                    <canvas id="chartKunjungan" style="height:250px; width:100%"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header" style="background-color:rgb(70, 174, 117);">
                    <h4 style="font-size: 22px;text-align:center;color: white;">Pendapatan Klinik Per Bulan</h4>
                </div>
                <div class="card-body bg-white">
                    <canvas id="chartPendapatan" style="height:250px; width:100%"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Grafik Pendapatan Klinik -->


    <div class="row g-4 mt-3" style=" display: flex;align-items: stretch;">
        <?php
        $items = [
            ['icon' => 'fa-stethoscope', 'color' => '#008080', 'count' => $total_dokter, 'label' => 'Jumlah Dokter'],
            ['icon' => 'fa-user-md', 'color' => '#d64242', 'count' => $total_perawat, 'label' => 'Jumlah Perawat'],
            ['icon' => 'fa-user-md', 'color' => '#0d6efd', 'count' => $total_farmasi, 'label' => 'Jumlah Farmasi'],
            ['icon' => 'fa-user', 'color' => '#ffa500', 'count' => $total_administrasi, 'label' => 'Jumlah Administrasi'],
            ['icon' => 'fa-user', 'color' => '#b87e14', 'count' => $total_kasir, 'label' => 'Jumlah Kasir'],
            ['icon' => 'fa-user', 'color' => '#808000', 'count' => $total_manajemen, 'label' => 'Jumlah Manajemen'],
        ];
        ?>


        <?php foreach ($items as $item): ?>
            <div class="col-md-6">
                <div class="card shadow-sm border-0 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fa <?= $item['icon'] ?> fa-4x" style="color: <?= $item['color'] ?>;"></i>
                        <div class="flex-grow-1">
                            <h2 class="text-dark fw-bold mb-0"><?= $item['count'] ?></h2>
                            <h4 class="text-muted mb-0" style="font-size: 1rem;"><?= $item['label'] ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="row">
        <div class="col-12">
            <center>
                <div class="card shadow-lg border-0 p-4 mt-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="d-flex align-items-center justify-content-center me-3">
                            <i class="fa fa-user fa-4x" style="color:#b22222"></i>
                        </div>
                        <div class="text-center">
                            <h2 class="text-dark fw-bold mb-1"><?= $total_pegawai ?></h2>
                            <h4 class="text-muted mb-0" style="font-size: 1rem;">Jumlah Pegawai Keseluruhan</h4>
                        </div>
                    </div>
                </div>
            </center>
        </div>
    </div>

    <!-- Grafik Layanan Terbanyak -->
    <div class="row" style="margin-top: 2rem;height:80%; ">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header" style="background-color: #A68EE9;">
                    <h4 style="font-size: 22px;text-align:center;color: white;">Layanan Terbanyak Digunakan</h4>
                </div>
                <div class="card-body bg-white" style="height:80%">
                    <canvas id="chartLayanan" style="width:100%"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header" style="background-color:rgb(167, 169, 108);">
                    <h4 style="font-size: 22px;text-align:center;color: white;">Data Kunjungan Poli</h4>
                </div>
                <div class="card-body bg-white" style="height:80%">
                    <canvas id="chartKunjunganPoli" style="width:100%"></canvas>
                </div>
            </div>
        </div>
    </div>


</div>




<?php
$this->registerJs(
    "$(document).ready(function() {
        var kunjunganData = " . Json::encode($jumlah_kunjungan) . ";
        var layananData = " . Json::encode($layananTerbanyak) . ";
        var pendapatanData = " . Json::encode($pendapatanPerBulan) . ";
        var kunjunganPoli = " . Json::encode($kunjunganPerPoli) . ";

        // Fungsi untuk menghasilkan warna acak
        function generateColor(data) {
            var color = [];
            for (let i = 0; i < data.length; i++) {
                color.push('#' + Math.floor(Math.random() * 16777215).toString(16)); // Warna acak
            }
            return color;
        }

        if (typeof Chart !== 'undefined') {
            // Grafik Kunjungan Pasien
            new Chart(document.getElementById('chartKunjungan').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: kunjunganData.map(d => 'Bulan ' + d.bulan_nama),
                    datasets: [{
                        label: 'Jumlah Kunjungan',
                        data: kunjunganData.map(d => d.total),
                        backgroundColor: generateColor(kunjunganData) // Warna statis jika diinginkan
                    }]
                }
            });
            
            // Grafik Layanan Terbanyak
            new Chart(document.getElementById('chartLayanan').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: layananData.map(d => d.layanan),
                    datasets: [{
                        label: 'Total',
                        data: layananData.map(d => d.total),
                        backgroundColor: generateColor(layananData) // Menggunakan warna acak
                    }]
                }
            });

            // Grafik Kunjungan Per Poli
            new Chart(document.getElementById('chartKunjunganPoli').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: kunjunganPoli.map(d => d.poli),
                    datasets: [{
                        label: 'Total',
                        data: kunjunganPoli.map(d => d.total),
                        backgroundColor: generateColor(kunjunganPoli) // Menggunakan warna acak
                    }]
                }
            });
            
            // Grafik Pendapatan Klinik
            new Chart(document.getElementById('chartPendapatan').getContext('2d'), {
                type: 'line',
                data: {
                    labels: pendapatanData.map(d => 'Bulan ' + d.bulan_nama),
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: pendapatanData.map(d => d.total),
                        backgroundColor: generateColor(pendapatanData), 
                        borderWidth: 2
                    }]
                }
            });
        } else {
            console.error('Chart.js gagal dimuat!');
        }
    });",
    View::POS_END
);
?>