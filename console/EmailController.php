<?php

namespace app\console;

use app\models\PaketPekerjaan;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class EmailController extends Controller
{
    public function actionNotifikasi()
    {
        $count_paket_baru = PaketPekerjaan::find()->where(['status_view' => 0])->count();

        if ($count_paket_baru > 0) {
            return
                Yii::$app->mailer
                ->compose(
                    ['html' => 'notifikasiPaket-html', 'text' => 'notifikasiPaket-text'],
                    ['count' => $count_paket_baru, 'app_name' => Yii::$app->name]
                )
                ->setFrom([Yii::$app->params['adminEmail'] => 'Bappeda Kota Medan'])
                ->setTo('nurulandini96@gmail.com')
                ->setSubject('Notifikasi Paket Baru CSR Pemerintah Kota Medan')
                ->send();
        } else {
            echo "Tidak ada data baru";
        }
    }
}
