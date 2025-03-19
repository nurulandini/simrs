<?php

namespace app\console;

use Exception;
use PhpParser\Node\Stmt\TryCatch;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class InsertController extends Controller
{
    public function actionTambahProvinsi($nama_file)
    {
        $json = file_get_contents(Yii::getAlias('@app/console/file/' . $nama_file . '.json'));
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            foreach (json_decode($json) as $index => $data) {
                $model = \app\models\WilayahProvinsi::findOne(['id' => $data->id, 'provinsi' => $data->provinsi]);

                if (!$model) {
                    $model = new \app\models\WilayahProvinsi();
                }

                $model->id = $data->id;
                $model->provinsi = $data->provinsi;
                $model->kd_provinsi = $data->kd_provinsi;
                $model->created_at = time();
                $model->updated_at = time();

                if ($model->save()) {
                    var_dump($model->provinsi . 'done');
                } else {
                    var_dump($model->errors);
                }
            }

            $transaction->commit();
        } catch (\Throwable $th) {
            $transaction->rollBack();
            echo $th;
        }
    }

    public function actionTambahKabupatenKota($nama_file)
    {
        $json = file_get_contents(Yii::getAlias('@app/console/file/' . $nama_file . '.json'));
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            foreach (json_decode($json) as $index => $data) {
                $model = \app\models\WilayahKabupatenKota::findOne(['id' => $data->id, 'kabupaten_kota' => $data->kabupaten_kota]);

                if (!$model) {
                    $model = new \app\models\WilayahKabupatenKota();
                }

                $model->id = $data->id;
                $model->provinsi_id = $data->provinsi_id;
                $model->kd_kabupaten_kota = $data->kd_kabupaten_kota;
                $model->kabupaten_kota = $data->kabupaten_kota;
                $model->created_at = time();
                $model->updated_at = time();

                if ($model->save()) {
                    var_dump($model->kabupaten_kota . ' done');
                } else {
                    var_dump($model->errors);
                }
            }

            $transaction->commit();
        } catch (\Throwable $th) {
            $transaction->rollBack();
            echo $th;
        }
    }

    public function actionTambahKecamatan($nama_file)
    {
        $json = file_get_contents(Yii::getAlias('@app/console/file/' . $nama_file . '.json'));
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            foreach (json_decode($json) as $index => $data) {
                $model = \app\models\WilayahKecamatan::findOne(['id' => $data->id, 'kecamatan' => $data->kecamatan]);

                if (!$model) {
                    $model = new \app\models\WilayahKecamatan();
                }

                $model->id = $data->id;
                $model->kabupaten_kota_id = $data->kabupaten_kota_id;
                $model->kd_kecamatan = $data->kd_kecamatan;
                $model->kecamatan = $data->kecamatan;
                $model->created_at = time();
                $model->updated_at = time();

                if ($model->save()) {
                    var_dump($model->kecamatan . ' done');
                } else {
                    var_dump($model->errors);
                }
            }
            $transaction->commit();
        } catch (\Throwable $th) {
            $transaction->rollBack();
            echo $th;
        }
    }

    public function actionTambahKelurahan($nama_file)
    {
        $json = file_get_contents(Yii::getAlias('@app/console/file/' . $nama_file . '.json'));
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            foreach (json_decode($json) as $index => $data) {
                $model = \app\models\WilayahKelurahan::findOne(['id' => $data->id, 'kelurahan' => $data->kelurahan]);

                if (!$model) {
                    $model = new \app\models\WilayahKelurahan();
                }

                $model->id  = $data->id;
                $model->kecamatan_id  = $data->kecamatan_id;
                $model->kd_kelurahan = $data->kd_kelurahan;
                $model->kelurahan = $data->kelurahan;
                $model->created_at = time();
                $model->updated_at = time();

                if ($model->save()) {
                    var_dump($model->kelurahan . ' done');
                } else {
                    var_dump($model->errors);
                }
            }

            $transaction->commit();
        } catch (\Throwable $th) {
            $transaction->rollBack();
            echo $th;
        }
    }

    public function actionTambahSatuan($nama_file)
    {
        $json = file_get_contents(Yii::getAlias('@app/console/file/' . $nama_file . '.json'));
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            foreach (json_decode($json) as $index => $data) {
                $model = \app\models\DataSatuan::findOne(['satuan' => $data->satuan]);

                if (!$model) {
                    $model = new \app\models\DataSatuan();
                }

                $model->id = $data->id;
                $model->satuan  = $data->satuan;
                $model->created_at = time();
                $model->updated_at = time();

                if ($model->save()) {
                    var_dump($model->satuan . ' done');
                } else {
                    var_dump($model->errors);
                }
            }
            $transaction->commit();
        } catch (\Throwable $th) {
            $transaction->rollBack();
            echo $th;
        }
    }

    public function actionLayanan($nama_file)
    {
        $json = file_get_contents(Yii::getAlias('@app/console/file/' . $nama_file . '.json'));
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            foreach (json_decode($json) as $index => $data) {
                $model = \app\models\LayananMedis::findOne(['layanan' => $data->layanan]);

                if (!$model) {
                    $model = new \app\models\LayananMedis();
                }

                $model->id = $data->id;
                $model->layanan  = $data->layanan;
                $model->deskripsi  = $data->deskripsi;
                $model->biaya  = $data->biaya;
                $model->created_at = $data->created_at;
                $model->updated_at = $data->updated_at;
                $model->created_by = $data->created_by;
                $model->updated_by = $data->updated_by;

                if ($model->save()) {
                    var_dump($model->layanan . ' done');
                } else {
                    var_dump($model->errors);
                }
            }
            $transaction->commit();
        } catch (\Throwable $th) {
            $transaction->rollBack();
            echo $th;
        }
    }

    public function actionObat($nama_file)
    {
        $json = file_get_contents(Yii::getAlias('@app/console/file/' . $nama_file . '.json'));
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            foreach (json_decode($json) as $index => $data) {
                $model = \app\models\DataObat::findOne(['nama' => $data->nama]);

                if (!$model) {
                    $model = new \app\models\DataObat();
                }

                $model->id = $data->id;
                $model->nama  = $data->nama;
                $model->kategori_id  = $data->kategori_id;
                $model->satuan_id  = $data->satuan;
                $model->deskripsi  = $data->deskripsi;
                $model->persediaan  = $data->persediaan;
                $model->tanggal_kedaluwarsa  = $data->tanggal_kedaluwarsa;
                $model->harga_per_unit  = $data->harga_per_unit;
                $model->created_at = $data->created_at;
                $model->updated_at = $data->updated_at;
                $model->created_by = $data->created_by;
                $model->updated_by = $data->updated_by;

                if ($model->save()) {
                    var_dump($model->nama . ' done');
                } else {
                    var_dump($model->errors);
                }
            }
            $transaction->commit();
        } catch (\Throwable $th) {
            $transaction->rollBack();
            echo $th;
        }
    }
}
