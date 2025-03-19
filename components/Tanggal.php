<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

date_default_timezone_set("Asia/Jakarta");

class Tanggal extends Component {

    // konversi UNIX timestamp ke tanggal hari indonesia
    // input : UNIX timestamp
    // output : hari, tanggal bulan tahun jam
    public function waktu($waktu, $enable_hari = true, $enable_tanggal = true, $enable_bulan = true, $enable_tahun = true, $enable_jam = true)
    {
        $hari_array = array(
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        );
        $hr = date('w', $waktu);
        $hari = $hari_array[$hr];
        $tanggal = date('j', $waktu);
        $bulan_array = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        );
        $bl = date('n', $waktu);
        $bulan = $bulan_array[$bl];
        $tahun = date('Y', $waktu);
        $jam = date( 'H:i:s', $waktu);

        $hari = ($enable_hari) ? $hari.', ' : '';
        $tanggal = ($enable_tanggal) ? $tanggal : '';
        $bulan = ($enable_bulan) ? $bulan : '';
        $tahun = ($enable_tahun) ? $tahun : '';
        $jam = ($enable_jam) ? $jam.' WIB' : '';
        
        $date = "$hari $tanggal $bulan $tahun $jam";
        return $date;
    }

    // konversi UNIX timestamp ke hari indonesia
    // input : UNIX timestamp
    // output : hari
    public function hari($waktu)
    {
        $hari_array = array(
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        );
        $hr = date('w', $waktu);
        $hari = $hari_array[$hr];
        
        return $hari;
    }

    // public function getbulan($id) {
    //     $bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    //     return $bulan[$id-1];
    // }

    // public function gethari($id) {
    //     $hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
    //     return $hari[$id-1];
    // }

    // public function getcurrency($id) {
    //     $id--;
    //     if ($id == 0) {
    //         return '0';
    //     }
    //     $str = '';
    //     $temp = 0;
    //     while ($id >= 1000) {
    //         $temp = $id % 1000;
    //         $str = '.' . str_pad($temp, 3, "0", STR_PAD_LEFT) . $str;
    //         $id = (int) ($id / 1000);
    //     }
    //     return $id . $str . ',00';
    // }

    public function getDay($data) {

        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );

        $Hari = $dayList[$data];
        return  $Hari;
    }

    public function getMonth($data) {

        $monthList  = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        );

        $Bulan = $monthList[$data];
        return $Bulan;
    }
}
