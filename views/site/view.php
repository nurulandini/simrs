<?php

use app\models\BeritaAcaraAmbilPaketDetail;
use app\models\BeritaAcaraVerifikasiPaketDetail;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Perusahaan;
use app\models\DataPerusahaanFile;
use app\models\DataPerusahaanSosialMedia;
use app\models\RealisasiPaketPekerjaan;
use Carbon\Carbon;
use kartik\grid\GridView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Perusahaan $model */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Daftar Perusahaan', 'url' => ['dataper']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$total_realisasi = 0;
foreach ($realisasi_pekerjaan->all() as $value) {
    $total_realisasi += floatval($value->detailPaket->anggaran);
}

$file_ = '';
$file = DataPerusahaanFile::find()->where(['perusahaan_id' => $model->id])->all();
if ($file) {
    foreach ($file as $file) {
        $url = Yii::$app->storageCsr->getPresignedUrl($file->nama_file);
        // $file_ .= Html::a(
        //     $file->nama_file_asli,
        //     $url,
        //     ['class' => 'btn btn-success btn-xs', 'target' => '_blank', 'data-pjax' => 0]
        // ) . "<br>";
    }
} else {
    return 'Tidak Ada File';
}




$this->registerJs("
$( document ).ready(function() {
    $('.register-box').delay(700).animate({ opacity: 1 }, 700);
});
");
?>

<style>
    .register-box {
        opacity: 0;
        width: 80%;
        margin-left: auto;
        margin-right: auto;
    }

    .styled-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }
</style>
<div class="site-view mitra">
    <!-- <img src="<=  $dt; ?>" type="image" style="height: 95px; border:3px solid #fff; box-sizing: border-box;"> -->
    <div class="container" style="padding-bottom:100px;margin-top:-30px">
        <div class="row justify-content-center register-box">
            <div class="col-md-4">
                <div>
                    <img src="<?= yii\helpers\Url::to($url) ?>" style="width:auto;max-width:300px;display:block; margin-left:auto;margin-right:auto;margin-bottom:50px;">
                </div>
                <div>
                    <h4 style="text-align: center;color: #1F439B"><b><?= Html::encode($model->nama); ?></b></h4>
                </div>
                <div>
                    <h4 style="text-align: center;font-size:18px;color:#FCB415"><?= Html::encode($model->jenis_perusahaan); ?></h4>
                </div>
                <div>
                    <h4 style="text-align: center;font-size:18px;color: #1F439B"><?= Html::encode($model->negara_asal); ?></h4>
                </div>
            </div>
            <div class="col-md-8">
                <div class="justify-content-left">
                    <h2 style="font-size: 18px;color:#1F439B"><b>Profil Perusahaan</b></h2>
                    <p class="text-justify"><?= Html::encode($model->deskripsi); ?></p>
                </div>
                <div class="justify-content-left" style="padding-top: 10px;">
                    <h2 style="font-size: 18px;color:#1F439B"><b>Informasi Perusahaan</b></h2>
                </div>
                <div class="justify-content-left">
                    <table>
                        <tr>
                            <td>
                                <div>
                                    <img src="<?= yii\helpers\Url::to('@web/img/lokasi.png') ?>" alt="" style="width:auto;max-width:20px">
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 16px;padding-left:10px;">
                                    <?= Html::encode($model->alamat) . ', Kel. ' . $model->kelurahan->kelurahan . ', Kec. ' . $model->kelurahan->kecamatan->kecamatan; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="padding-top: 15px;">
                                    <img src="<?= yii\helpers\Url::to('@web/img/sosmed/email.png') ?>" alt="" style="width:auto;max-width:25px">
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 16px;padding-left:10px;padding-top:15px">
                                    <?php
                                    if ($model->email != null) {
                                        echo Html::encode($model->email);
                                    } else {
                                        echo Html::encode($model->user->email);
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="padding-top:20px;margin-left:-15px">
                    <?php
                    $sosmed = DataPerusahaanSosialMedia::findAll(['perusahaan_id' => $model->id]);
                    if ($sosmed) {
                        $sosmed_teks = "";
                        foreach ($sosmed as $sosmeds) {
                            $sosmed_teks = $sosmed_teks . '&emsp;<a href="' . yii\helpers\Url::to($sosmeds->url) . '" target ="_blank"><img src= "' . yii\helpers\Url::to('@web/img/sosmed/' . $sosmeds->jenis_sosial_media . '.png') . '" style ="width:auto;max-width:25px;" ></a>';
                        }
                        echo $sosmed_teks;
                    } else {
                        echo 'Tidak Ada Sosial Media';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-12" style="padding-top: 50px;">
                <div class="text-center">
                    <h2 style="font-size: 18px;color:#1F439B"><b>Riwayat Realisasi CSR Perusahaan</b></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card-header text-center shadow-lg " style="background-color:#0E3083;border-radius:10px;margin-left: auto;margin-right:auto;width:auto; height:10%">
                <div style="overflow: auto;">
                    <h2 style="color: #FCB415;"><b><?= Yii::$app->formatter->asCurrency($total_realisasi); ?></b></h2>
                    <h4 style="color: white;">Total Realisasi Anggaran CSR</h4>
                </div>
            </div>
            <div class="card-body">
                <div style="overflow: auto;">
                    <?= GridView::widget(
                        [
                            'dataProvider' => $dataProvider,
                            // 'filterModel' => $searchModel,
                            'pager' => [
                                'class' => \yii\bootstrap4\LinkPager::class,
                            ],
                            'options' => [
                                'style' => 'width: 70%;margin-left: auto;margin-right:auto;',
                            ],
                            'tableOptions' => [
                                'class' => 'styled-table',
                                'style' => 'font-size: 12px;',
                            ],
                            'toolbar' => [
                                [
                                    'content' => Html::a(
                                        '<i class="fa fa-redo"></i>',
                                        [''],
                                        ['data-pjax' => 1, 'class' => 'btn btn-outline-success', 'title' => Yii::t('yii2-ajaxcrud', 'Reset Grid')]
                                    ) .
                                        '{toggleData}',

                                ],
                            ],
                            'striped' => true,
                            'condensed' => true,
                            'responsive' => true,
                            'floatHeader' => true,
                            'hover' => true,
                            'panel' => [
                                'type' => 'default',
                            ],
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\SerialColumn',
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'label' => 'Paket Pekerjaan',
                                    'filter' => false,
                                    'format' => 'raw',
                                    'headerOptions' => [

                                        'style' => 'text-align:left;border:0px;width:50%'
                                    ],
                                    'value' => function ($model) {
                                        if (Yii::$app->manage->roleCheck("admin_sistem") || Yii::$app->manage->roleCheck("Operator")) {
                                            $pengusul = "";
                                            $asal_usulan = "";

                                            if ($model->masyarakat_id) {
                                                $pengusul = $model->masyarakat->nama;
                                            } elseif ($model->lsm_id) {
                                                $pengusul = $model->lsm->nama;
                                            } elseif ($model->sub_unit_id) {
                                                $pengusul = $model->subUnit->sub_unit;
                                            } elseif ($model->perusahaan_id) {
                                                $pengusul = $model->perusahaan->nama;
                                            }

                                            if ($model->asal_usulan == 1) {
                                                $asal_usulan = "UMKM";
                                            } elseif ($model->asal_usulan == 2) {
                                                $asal_usulan = "LSM";
                                            } elseif ($model->asal_usulan == 3) {
                                                $asal_usulan = "Kelurahan";
                                            } elseif ($model->asal_usulan == 4) {
                                                $asal_usulan = "Kecamatan";
                                            } elseif ($model->asal_usulan == 5) {
                                                $asal_usulan = "OPD";
                                            } elseif ($model->asal_usulan == 6) {
                                                $asal_usulan = "Lainnya";
                                            }

                                            if ($model->status_view == 0) {
                                                $baru = '<span class = "badge badge-success">New</span><br>';
                                            } else {
                                                $baru = "";
                                            }

                                            return  '
                                    <span class="card-title font-weight-bold text-success">' . $model->nama . '</span> &emsp;' . $baru . '
                                    <p class="card-text text-sm mb-1">' . $model->deskripsi . '</p><p></p>
                                    <p class="card-text text-sm mb-1"><b>Pengusul Paket : </b><span class="text-secondary">' . $pengusul . ' </span></p>
                                    <p class="card-text text-sm mb-1"><b>Asal Usulan : </b><span class="text-secondary">' . $asal_usulan . ' </span></p>
                                    <p class="card-text text-sm mb-1"><b>Penerima Manfaat : </b><span class="text-secondary">' . $model->penerima . ' </span></p>
                                    <p class="card-text text-sm mb-1"><b>Bidang CSR : </b><span class="text-secondary">' . $model->bidang->nama . '</span></p>
                                    <p class="card-text text-sm mb-1"><b>Jenis CSR : </b><span class="text-secondary">' . $model->jenis->nama . '</span></p>
                                    <p class="card-text text-sm mb-1"><b>Tahun Usulan : </b><span class="text-secondary">' . $model->tahun->tahun . '</span></p>
                        
                                    ';
                                        } else {
                                            $pengusul = "";
                                            $asal_usulan = "";

                                            if ($model->masyarakat_id) {
                                                $pengusul = $model->masyarakat->nama;
                                            } elseif ($model->lsm_id) {
                                                $pengusul = $model->lsm->nama;
                                            } elseif ($model->sub_unit_id) {
                                                $pengusul = $model->subUnit->sub_unit;
                                            } elseif ($model->perusahaan_id) {
                                                $pengusul = $model->perusahaan->nama;
                                            }

                                            if ($model->asal_usulan == 1) {
                                                $asal_usulan = "UMKM";
                                            } elseif ($model->asal_usulan == 2) {
                                                $asal_usulan = "LSM";
                                            } elseif ($model->asal_usulan == 3) {
                                                $asal_usulan = "Kelurahan";
                                            } elseif ($model->asal_usulan == 4) {
                                                $asal_usulan = "Kecamatan";
                                            } elseif ($model->asal_usulan == 5) {
                                                $asal_usulan = "OPD";
                                            } elseif ($model->asal_usulan == 6) {
                                                $asal_usulan = "Lainnya";
                                            } elseif ($model->asal_usulan == 7) {
                                                $asal_usulan = "Perusahaan";
                                            }

                                            return '<span class="card-title font-weight-bold text-success">' . $model->nama . '</span><br>
                                    <p class="card-text text-sm mb-1">' . $model->deskripsi . '</p><p></p>
                                    <p class="card-text text-sm mb-1"><b>Pengusul Paket : </b><span class="text-secondary">' . $pengusul . ' </span></p>
                                    <p class="card-text text-sm mb-1"><b>Asal Usulan : </b><span class="text-secondary">' . $asal_usulan . ' </span></p>
                                    <p class="card-text text-sm mb-1"><b>Penerima Manfaat : </b><span class="text-secondary">' . $model->penerima . ' </span></p>
                                    <p class="card-text text-sm mb-1"><b>Bidang CSR : </b><span class="text-secondary">' . $model->bidang->nama . '</span></p>
                                    <p class="card-text text-sm mb-1"><b>Jenis CSR : </b><span class="text-secondary">' . $model->jenis->nama . '</span></p>
                                    <p class="card-text text-sm mb-1"><b>Tahun Usulan : </b><span class="text-secondary">' . $model->tahun->tahun . '</span></p>
                                    ';
                                        }
                                    }
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'format' => 'raw',
                                    'label' => 'Lokasi',
                                    'headerOptions' => [

                                        'style' => 'text-align:left;border:0px;'
                                    ],
                                    'value' => function ($model) {
                                        $kelurahan = isset($model->kelurahan_id) ? $model->kelurahan->kelurahan : '-';
                                        $kecamatan = isset($model->kelurahan_id) ? $model->kelurahan->kecamatan->kecamatan : '-';

                                        return '<p class="card-text text-success text-sm"><i class="fa fa-road text-secondary"></i> ' . $model->alamat . '</p>
                                    <p class="card-text text-sm mt-1"><b>Kelurahan : </b><span class="text-secondary">' . $kelurahan .
                                            '</span><br><b>Kecamatan : </b><span class="text-secondary">' . $kecamatan . '</span></p>
                                    ';
                                    }
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'format' => 'raw',
                                    'label' => 'Volume Paket/ Perkiraan Anggaran',
                                    'headerOptions' => [

                                        'style' => 'width:30%;text-align:left;border:0px;width:20%'
                                    ],
                                    'value' => function ($model) {

                                        $pengesahan = BeritaAcaraVerifikasiPaketDetail::findOne(['paket_pekerjaan_id' => $model->id]);
                                        $ambil = BeritaAcaraAmbilPaketDetail::find()->where(['paket_pekerjaan_id' => $model->id])->all();

                                        $volume_pengambilan = "";
                                        $volume_realisasi = "";
                                        $anggaran_realisasi = "";
                                        foreach ($ambil as $ambil) {
                                            $volume_pengambilan .= '<span class="text-secondary"><br><i class="fa fa-cubes text-warning"></i>&nbsp;&nbsp;' .  number_format($ambil->volume, 0, ",", ".") . " " . $model->satuan->satuan . '</span>&nbsp;<span class="badge badge-info" style ="font-size:10px">' . $ambil->perusahaan->nama . '</span>';
                                            $tanggal_realisasi = RealisasiPaketPekerjaan::findOne(['detail_paket_id' => $ambil->id]);
                                            if (isset($tanggal_realisasi)) {
                                                $volume_realisasi .= '<span class="text-secondary"><br><i class="fa fa-cubes text-success"></i>&nbsp;&nbsp;' .  number_format($ambil->volume, 0, ",", ".") . " " . $model->satuan->satuan . '</span>&nbsp;<span class="badge badge-info" style ="font-size:10px">' . $ambil->perusahaan->nama . '</span>';
                                                $anggaran_realisasi .= '<span class="text-secondary"><br><i class="fa fa-cubes text-success"></i>&nbsp;&nbsp; Rp.' .  number_format($ambil->anggaran, 0, ",", ".") . " " . '</span>&nbsp;<span class="badge badge-info" style ="font-size:10px">' . $ambil->perusahaan->nama . '</span>';
                                            } else {
                                                $volume_realisasi .= '<span class="text-secondary"><br><i class="fa fa-cubes text-success"></i>&nbsp;&nbsp; 0' . " " . $model->satuan->satuan . ' </span>&nbsp';
                                            }
                                        }


                                        return '
                                       <p class="card-text text-sm"><b>Paket Tersedia</b><span class="text-secondary"><br><i class="fa fa-cubes text-secondary"></i>&nbsp;&nbsp; ' . ($model->satuan->satuan == 'Rupiah' ? "Rp. " .  number_format($model->volume, 0, ",", ".") . " "  : $model->volume . " " . $model->satuan->satuan) . '</span></p>
                                       <p class="card-text text-sm"><b>Perkiraan Anggaran</b><span class="text-secondary"><br><i class="fa fa-money-bill text-success"></i>&nbsp;&nbsp; Rp. ' . number_format($model->anggaran, 0, ",", ".") . '</span></p>
                                       <p class="card-text text-sm"><b>Sisa Paket Tersedia</b><span class="text-secondary"><br><i class="fa fa-cubes text-primary"></i>&nbsp;&nbsp; ' . $model->getVolumeFormatBeritaAcara(true) . " " . $model->satuan->satuan . '</span></p>
                                       <p class="card-text text-sm"><b>Paket Diambil</b>' . ($pengesahan ?  ($ambil ? $volume_pengambilan : '<br> <span class="text-secondary"><i class="fa fa-cubes text-warning"></i>&nbsp;&nbsp; 0 ' . $model->satuan->satuan) : '<span class="text-secondary"><br><i class="fa fa-cubes text-warning"></i>&nbsp;&nbsp; 0 ' . $model->satuan->satuan) . '</span></p>
                                       <p class="card-text text-sm"><b>Paket Terealisasi</b>' . ($ambil ?  $volume_realisasi : '<br> <span ><i class="fa fa-cubes text-success"></i>&nbsp;&nbsp; 0 ' . $model->satuan->satuan) . '</span></p>
                                       <p class="card-text text-sm"><b>Anggaran Terealisasi</b>' . ($ambil ?  $anggaran_realisasi : '<br> <span ><i class="fa fa-cubes text-success"></i>&nbsp;&nbsp; Rp.0,- ') . '</span></p>';
                                    },
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'format' => 'raw',
                                    'label' => 'Tanggal Realisasi',
                                    'headerOptions' => [

                                        'style' => 'text-align:left;border:0px;width:20%'
                                    ],
                                    'value' => function ($model) {
                                        $pengesahan = BeritaAcaraVerifikasiPaketDetail::findOne(['paket_pekerjaan_id' => $model->id]);
                                        $ambil = BeritaAcaraAmbilPaketDetail::find()->where(['paket_pekerjaan_id' => $model->id])->all();
                                        $hari = Carbon::parse($model->created_at)->locale('id');
                                        $hari->settings(['formatFunction' => 'translatedFormat']);
                                        $tanggal_usulan = $hari->format('l, j F Y ');

                                        if (isset($pengesahan)) {
                                            $hari1 = Carbon::parse($pengesahan->beritaAcara->tanggal)->locale('id');
                                            $hari1->settings(['formatFunction' => 'translatedFormat']);
                                            $tanggal_pengesahan = $hari1->format('l, j F Y ');

                                            $tanggal_pengambilan = "";
                                            $realisasi = "";
                                            foreach ($ambil as $ambil) {
                                                $hari2 = Carbon::parse($ambil->beritaAcara->tanggal)->locale('id');
                                                $hari2->settings(['formatFunction' => 'translatedFormat']);
                                                $tanggal_pengambilan .= '<span class="text-secondary"><br><i class="fa fa-calendar text-success"></i>&nbsp;&nbsp;' . $hari2->format('l, j F Y ') . '</span>';

                                                $tanggal_realisasi = RealisasiPaketPekerjaan::findOne(['detail_paket_id' => $ambil->id]);
                                                if (isset($tanggal_realisasi->tanggal)) {
                                                    $hari3 = Carbon::parse($tanggal_realisasi->tanggal)->locale('id');
                                                    $hari3->settings(['formatFunction' => 'translatedFormat']);
                                                    $realisasi = $realisasi . '<span class="text-secondary"><br><i class="fa fa-calendar text-success"></i>&nbsp;&nbsp;' . $hari3->format('l, j F Y ') . '</span>' . '</span>&nbsp;<span class="badge badge-info" style ="font-size:10px">' . $ambil->perusahaan->nama . '</span>';
                                                }
                                            }
                                        }

                                        return '
                                       <p class="card-text text-sm">' . ($ambil ?    $realisasi : "<br> Paket Belum Direalisasi") . '</p>';
                                    },
                                ],

                                [
                                    'header' => 'Aksi',
                                    'headerOptions' => [

                                        'style' => 'text-align: center !important;'
                                    ],
                                    'format' => 'raw',
                                    'contentOptions' => ['style' => 'text-align: center !important;', 'class' => 'align-middle'],
                                    'value' => function ($model, $key, $index, $column) {
                                        return Html::a(
                                            '<h4 class="btn btn-info" style = "font-size:12px"> Lihat </h4>',
                                            Url::to(['site/detail-program', 'id' => $model->id]),
                                        );
                                    }
                                ],
                            ],
                        ]
                    ); ?>
                </div>

            </div>
        </div>
    </div>
</div>