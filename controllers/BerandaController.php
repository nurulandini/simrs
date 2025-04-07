<?php

namespace app\controllers;

use app\models\DataPendaftaranPasien;
use app\models\DataRekamMedis;
use app\models\DataResepDetail;
use app\models\RekamMedisDetail;
use app\models\Transaksi;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\User;
use yii\web\NotFoundHttpException;
use app\models\WilayahKecamatan;
use app\models\WilayahKelurahan;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class BerandaController extends \yii\web\Controller
{
    public function actions()
    {
        $this->layout = 'theme/main';
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionBeranda()
    {

        $connection = Yii::$app->db;

        // **1. Data untuk Card (Total Angka)**
        $hariSekarang = date('d'); // Mendapatkan bulan saat ini
        $bulanSekarang = date('m'); // Mendapatkan bulan saat ini
        $tahunSekarang = date('Y'); // Mendapatkan tahun saat ini

        $totalpengunjung_keseluruhan = (new Query())->from('data_pendaftaran_pasien')->count();

        $totalPengunjungBulanIni = (new Query())
            ->from('data_pendaftaran_pasien')
            ->select(['COUNT(*) as total', 'MONTH(tanggal_kunjungan) as bulan', 'YEAR(tanggal_kunjungan) as tahun'])
            ->where(['MONTH(tanggal_kunjungan)' => $bulanSekarang])
            ->andWhere(['YEAR(tanggal_kunjungan)' => $tahunSekarang])
            ->groupBy(['bulan', 'tahun'])
            ->one();

        $totalTransaksiBulanIni = (new Query())
            ->from('transaksi')
            ->select(["SUM(total_harga) AS total"])
            ->where("MONTH(FROM_UNIXTIME(created_at)) = :bulan AND YEAR(FROM_UNIXTIME(created_at)) = :tahun", [
                ':bulan' => $bulanSekarang,
                ':tahun' => $tahunSekarang
            ])
            ->andWhere(['status_pembayaran' => 1])
            ->scalar();

        $totalTransaksiHariIni = (new Query())
            ->from('transaksi')
            ->select(["SUM(total_harga) AS total"])
            ->where("DAY(FROM_UNIXTIME(created_at)) = :hari AND MONTH(FROM_UNIXTIME(created_at)) = :bulan AND YEAR(FROM_UNIXTIME(created_at)) = :tahun", [
                ':hari' => $hariSekarang,
                ':bulan' => $bulanSekarang,
                ':tahun' => $tahunSekarang
            ])
            ->andWhere(['status_pembayaran' => 1])
            ->scalar();

        $totalPengunjungHariIni = (new Query())
            ->from('data_pendaftaran_pasien')
            ->select(['COUNT(*) as total', 'DAY(tanggal_kunjungan) as hari', 'MONTH(tanggal_kunjungan) as bulan', 'YEAR(tanggal_kunjungan) as tahun'])
            ->where(['DAY(tanggal_kunjungan)' => $hariSekarang])
            ->andwhere(['MONTH(tanggal_kunjungan)' => $bulanSekarang])
            ->andWhere(['YEAR(tanggal_kunjungan)' => $tahunSekarang])
            ->groupBy(['hari', 'bulan', 'tahun'])
            ->scalar();

        $totalPengunjung = $totalPengunjungBulanIni['total'] ?? 0;
        $totaldata_pegawai = (new Query())->from('data_pegawai')->count();
        $data_pegawaiPerPoli = (new Query())
            ->select(['data_poli.poli AS poli', 'COUNT(data_pegawai.id) AS total'])
            ->from('data_pegawai')
            ->leftJoin('data_poli', 'data_pegawai.poli_id = data_poli.id')
            ->groupBy('data_poli.id')
            ->all();
        $dokterPerawatPerPoli = (new Query())
            ->select([
                'data_poli.poli AS poli',
                'SUM(CASE WHEN auth_assignment.item_name = "Dokter" THEN 1 ELSE 0 END) AS total_dokter',
                'SUM(CASE WHEN auth_assignment.item_name = "Perawat" THEN 1 ELSE 0 END) AS total_perawat'
            ])
            ->from('auth_assignment')
            ->leftJoin('user', 'auth_assignment.user_id = user.id')
            ->leftJoin('data_pegawai', 'user.pegawai_id = data_pegawai.id')
            ->leftJoin('data_poli', 'data_pegawai.poli_id = data_poli.id')
            ->groupBy('data_poli.id')
            ->all();


        $kunjunganPerBulan = (new Query())
            ->select([
                "MONTH(FROM_UNIXTIME(created_at)) AS bulan_angka",
                "DATE_FORMAT(FROM_UNIXTIME(created_at), '%M') AS bulan_nama",
                "COUNT(*) AS total"
            ])
            ->from('data_rekam_medis')
            ->groupBy('bulan_angka, bulan_nama')
            ->orderBy('bulan_angka')
            ->all();

        $bulanIndo = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        foreach ($kunjunganPerBulan as &$data) {
            $data['bulan_nama'] = $bulanIndo[$data['bulan_nama']] ?? $data['bulan_nama'];
        }
        $layananTerbanyak = (new Query())
            ->select([
                'layanan_medis.layanan AS layanan',
                'COUNT(*) AS total'
            ])
            ->from('rekam_medis_detail')
            ->leftJoin('layanan_medis', 'rekam_medis_detail.layanan_id = layanan_medis.id')
            ->groupBy('layanan_medis.id')
            ->orderBy(['total' => SORT_DESC])
            ->limit(5)
            ->all();


        $obatTerbanyak = (new Query())
            ->select([
                'data_obat.nama AS obat',
                'COUNT(*) AS total'
            ])
            ->from('data_resep_detail')
            ->leftJoin('data_obat', 'data_resep_detail.obat_id = data_obat.id')
            ->groupBy('data_obat.id')
            ->orderBy(['total' => SORT_DESC])
            ->limit(5)
            ->all();


            $pendapatanPerBulan = (new \yii\db\Query())
            ->select([
                "MONTH(FROM_UNIXTIME(created_at)) AS bulan_angka",
                "DATE_FORMAT(FROM_UNIXTIME(created_at), '%M') AS bulan_nama",
                "SUM(total_harga) AS total"
            ])
            ->from('transaksi')
            ->groupBy('bulan_angka, bulan_nama')
            ->orderBy('bulan_angka')
            ->all();
    
        foreach ($pendapatanPerBulan as &$data) {
            $data['bulan_nama'] = $bulanIndo[$data['bulan_nama']] ?? $data['bulan_nama'];
        }

        $totalTransaksi = (new Query())
            ->select([
                "SUM(total_harga) AS total"
            ])
            ->from('transaksi')
            ->where(['status_pembayaran' => 1])
            ->one();
        $totalHarga = $totalTransaksi['total'];

        $kunjunganPerPoli = (new Query())
            ->select([
                'data_poli.poli AS poli',
                'COUNT(data_rekam_medis.id) AS total'
            ])
            ->from('data_rekam_medis')
            ->leftJoin('data_skrinning', 'data_rekam_medis.skrinning_id = data_skrinning.id')
            ->leftJoin('data_pendaftaran_pasien', 'data_skrinning.pendaftaran_id = data_pendaftaran_pasien.id')
            ->leftJoin('data_pegawai', 'data_pendaftaran_pasien.pegawai_id = data_pegawai.id')
            ->leftJoin('data_poli', 'data_pegawai.poli_id = data_poli.id')
            ->groupBy('data_poli.id')
            ->orderBy(['total' => SORT_DESC])
            ->all();

        $dokterCount = (new Query())
            ->from('auth_assignment')
            ->where(['item_name' => 'Dokter'])
            ->count();

        $perawatCount = (new Query())
            ->from('auth_assignment')
            ->where(['item_name' => 'Perawat'])
            ->count();

        $farmasiCount = (new Query())
            ->from('auth_assignment')
            ->where(['item_name' => 'farmasi'])
            ->count();

        $administrasiCount = (new Query())
            ->from('auth_assignment')
            ->where(['item_name' => 'administrasi'])
            ->count();
        $kasirCount = (new Query())
            ->from('auth_assignment')
            ->where(['item_name' => 'kasir'])
            ->count();
        $manajemenCount = (new Query())
            ->from('auth_assignment')
            ->where(['item_name' => 'manajemen'])
            ->count();


        return $this->render('beranda', [
            'total_pengunjung' => $totalPengunjung,
            'total_pegawai' => $totaldata_pegawai,
            'total_dokter' => $dokterCount,
            'total_farmasi' => $farmasiCount,
            'total_kasir' => $kasirCount,
            'total_administrasi' => $administrasiCount,
            'total_manajemen' => $manajemenCount,
            'total_perawat' => $perawatCount,
            'data_pegawaiPerPoli' => $data_pegawaiPerPoli,
            'dokterPerawatPerPoli' => $dokterPerawatPerPoli,
            'jumlah_kunjungan' => $kunjunganPerBulan,
            'layananTerbanyak' => $layananTerbanyak,
            'obatTerbanyak' => $obatTerbanyak,
            'pendapatanPerBulan' => $pendapatanPerBulan,
            'kunjunganPerPoli' => $kunjunganPerPoli,
            'total_pengunjung_keseluruhan' => $totalpengunjung_keseluruhan,
            'totaltransaksi' => $totalHarga,
            'totalpengunjunghariini' => $totalPengunjungHariIni,
            'totaltransaksibulanini' => $totalTransaksiBulanIni,
            'totaltransaksihariini' => $totalTransaksiHariIni
        ]);
    }
}
