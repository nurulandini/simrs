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

<div class="container mt-4">
    <h3 class="mb-4 font-weight-bold text-primary">
        <i class="fas fa-hospital"></i> Dashboard Klinik
    </h3>

    <!-- Cards Total Data -->

    <div class="row">
        <div class="col-md-12 mb-3">
            <center>
                <div class="card">
                    <div class="card-header text-center shadow-lg " style="background-color:#008080">
                        <h2 style="color:white"><b> Rp <?= number_format($totaltransaksi, 0, ',', '.') ?></b></h2>
                        <h4 style="color: white;">Total Transaksi</h4>
                    </div>
                </div>
            </center>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <center>
                <div class="card">
                    <div class="card-header text-center shadow-lg " style="background-color:#7a7a7a">
                        <h2 style="color:white"><b><?= $total_pengunjung ?></b></h2>
                        <h4 style="color: white;">Total Pengunjung Bulan Ini</h4>
                    </div>
                </div>
            </center>
        </div>
        <div class="col-md-6 mb-3">
            <center>
                <div class="card">
                    <div class="card-header text-center shadow-lg " style="background-color:#67838c">
                        <h2 style="color:white;"><b><?= $total_pengunjung_keseluruhan ?></b></h2>
                        <h4 style="color: white;">Total Pengunjung Keseluruhan</h4>
                    </div>
                </div>
            </center>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12 mb-3">
            <div class="card mb-4">
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
        <div class="col-12 col-md-12 mb-3">
            <div class="card mb-4">
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

    <div class="col-12">
        <div class="row" style=" display: flex;align-items: stretch;">
            <div class="col-md-6" style="padding-top: 1rem;">
                <center>
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #987c73;">
                            <h2 style="color:white"><b><?= $total_dokter ?></b></h2>
                            <h4 style="color: white;font-size:1rem">Jumlah Dokter</h4> </a>
                        </div>
                    </div>
                </center>
            </div>
            <div class="col-md-6" style="padding-top: 1rem;">
                <center>
                    <div class="card-header text-center" style="background-color: #8b9ea4;">
                        <h2 style="color:white"><b><?= $total_perawat ?></b></h2>
                        <h4 style="color: white;font-size:1rem">Jumlah Perawat</h4>
                    </div>
                </center>
            </div>
            <div class="col-md-6" style="padding-top: 1rem;">
                <center>
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #964b00;">
                            <h2 style="color:white"><b><?= $total_farmasi ?></b></h2>
                            <h4 style="color:  white;font-size:1rem">Jumlah Farmasi</h4>

                        </div>
                    </div>
                </center>
            </div>
            <div class="col-md-6" style="padding-top: 1rem;">
                <center>
                    <div class="card">
                        <div class="card-header text-center" style="background-color:#CE6767">
                            <h2 style="color: white"><b><?= $total_administrasi ?></b></h2>
                            <h4 style="color: white;font-size:1rem">Jumlah Anggota Administrasi</h4>

                        </div>
                </center>
            </div>
            <div class="col-md-6" style="padding-top: 1rem;">
                <center>
                    <div class="card">
                        <div class="card-header text-center" style="background-color:#628591">
                            <h2 style="color:white"><b><?= $total_kasir ?></b></h2>
                            <h4 style="color:  white;font-size:1rem">Jumlah Anggota Kasir</h4>

                        </div>
                    </div>
                </center>
            </div>
            <div class="col-md-6" style="padding-top: 1rem;">
                <center>
                    <div class="card">
                        <div class="card-header text-center" style="background-color:#808000;">
                            <h2 style="color:white"><b><?= $total_manajemen ?></b></h2>
                            <h4 style="color: white;font-size:1rem">Jumlah Anggota Manajemen</h4>

                        </div>
                </center>
            </div>
            <div class="col-12" style="padding-top:1rem">
                <center>
                    <div class="card">

                        <div class="card-header text-center shadow-lg" style="background-color: #b22222;">
                            <h2 style="color: white"><b><?= $total_pegawai ?></b></h2>
                            <h4 style="color: white;font-size:16px">Jumlah Pegawai Keseluruhan</h4>

                        </div>
                    </div>
                </center>
            </div>

        </div>
    </div>

    <!-- Grafik Layanan Terbanyak -->
    <div class="row" style="margin-top: 1rem;height:80%; ">
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
                    labels: kunjunganData.map(d => 'Bulan ' + d.bulan),
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
                    labels: pendapatanData.map(d => 'Bulan ' + d.bulan),
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: pendapatanData.map(d => d.total),
                        backgroundColor: generateColor(pendapatanData), // Warna statis jika diinginkan
                        borderColor: generateColor(pendapatanData),
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