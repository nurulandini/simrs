<?php

namespace app\components;

use Yii;
use yii\base\Component;
use kartik\mpdf\Pdf;
use yii\helpers\Html;

class Printer extends Component
{
    /* function cetak_pdf
     ** referensi ada di API mPDF (https://mpdf.github.io)
     ** $content = konten yang akan dicetak ke pdf, hasil dari render parsial view
     ** $paper_size = ukuran kertas, referensi (https://mpdf.github.io/reference/mpdf-functions/construct.html)
     ** $orientation = enum('L', 'P')
     ** $start_page = bisa inisialisasi mulai halaman, misal mulai halaman 5
     ** $file_name = nama file pdf
     ** $style = file css custom utk cetak pdf
     ** $header_left = menampilkan header kiri
     ** $header_right = menampilkan header kanan
     ** $footer = menampilkan halaman footer
     ** $footer_left = menampilkan halaman footer_left
     ** $footer_right = menampilkan halaman footer_right
     ** $header = menampilkan header
     ** $watermark = menampilkan watermark
    */
    public function cetak_pdf($content, $paper_size, $orientation, $start_page, $file_name, $style = null, $header_left = true, $header_right = true, $footer = true, $footer_left = true, $footer_right = true, $header = true, $watermark = NULL)
    {
        (!is_null($style)) ? $style = $style : $style = Yii::getAlias('@vendor') . "/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css";

        $tanggal    = date('Y-m-d');
        $day        = date('D', strtotime($tanggal));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );

        $month      = date('m', strtotime($tanggal));
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

        $Hari       = $dayList[$day];
        $Bulan      = $monthList[$month];
        $Nm_Pemda   = 'Kota Medan';

        //$header_left ? $header_left_ = 'Dicetak dari: e-DevPlan Pemerintah '.$Nm_Pemda : $header_left_ = "";


        $pdf = new Pdf();
        $mpdf = $pdf->api;


        $footer_right ? $footer_right_ = 'Dicetak tanggal: ' .
            $Hari . ', ' . (date('d')) . ' ' .
            $Bulan . ' ' . (date('Y')) . ' ' . date('H:i:s') . ' WIB' : $footer_right_ = "";
        $header_right ? $header_right_ = "" : $header_right_ = "";

        $header ? $mpdf->SetHeader(\yii\helpers\Html::img('@web/img/logo1.png', ['alt' => 'Header Image', 'style' => 'width:20%;']) . '||' . $header_right_) : '';

        $footer_left ? $footer_left_ = $file_name : $footer_left_ = "";;
        $footer ? $mpdf->SetFooter($footer_left_ . '|Halaman {PAGENO}|' . $footer_right_) : '';

        if ($watermark) {
            $mpdf->SetWatermarkText($watermark);
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
        }

        $mpdf->AddPageByArray(array(
            'orientation' => $orientation,
            'resetpagenum' => $footer ? $start_page : 1,
            'pagenumstyle' => '1',
            'sheet-size' => ['216', '330'],
            'margin-top' =>  '28',
        ));
        $stylesheet = file_get_contents($style);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHtml($content);
        return $mpdf->Output($file_name . '.pdf', 'I');
    }
}
