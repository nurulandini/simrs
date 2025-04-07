<?php

namespace app\controllers;


use app\models\search\RekamMedisSearch;
use app\models\User;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\DataRekamMedis;
use app\models\DataRekamMedisDetail;
use app\models\DataResepDetail;
use app\models\DataLayanan;
use app\models\DataObat;
use app\models\DataSkrinning;
use app\models\LayananMedis;
use app\models\Model;
use app\models\RekamMedisDetail;
use yii\helpers\ArrayHelper;

/**
 * RekamMedisController implements the CRUD actions for DataRekamMedis model.
 */
class RekamMedisController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actions()
    {
        $this->layout = 'theme/main';
    }

    /**
     * Lists all DataRekamMedis models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RekamMedisSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DataRekamMedis model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = DataRekamMedis::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Data rekam medis tidak ditemukan.');
        }

        // Ambil data skrining
        $skrinning = DataSkrinning::findOne($model->skrinning_id);

        // Ambil data layanan medis terkait
        $layananMedis = RekamMedisDetail::find()->where(['rekam_medis_id' => $model->id])->all();

        // Ambil data resep obat terkait
        $resepObat = DataResepDetail::find()->where(['rekam_medis_id' => $model->id])->all();

        return $this->render('view', [
            'model' => $model,
            'skrinning' => $skrinning,
            'layananMedis' => $layananMedis,
            'resepObat' => $resepObat,
        ]);
    }

    /**
     * Creates a new DataRekamMedis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DataRekamMedis();


        $data_pegawai = User::find()
            ->joinWith('pegawai')
            ->where(['user.id' => Yii::$app->user->id])
            ->one();

        if (!$data_pegawai || !$data_pegawai->pegawai) {
            Yii::$app->session->setFlash('error', 'Anda tidak memiliki akses untuk ini.');
            return $this->redirect(['index']);
        }

        // Ambil daftar skrining sesuai poli dokter yang login
        $skrinningList = DataSkrinning::find()
            ->joinWith('pendaftaran.pegawai')
            ->where(['data_pegawai.poli_id' => $data_pegawai->pegawai->poli_id])
            ->andWhere(['data_skrinning.status' => 1])
            ->all();

        $skrinningDropdown = ArrayHelper::map($skrinningList, 'id', function ($skrinning) {
            return $skrinning->pendaftaran->pasien->nama;
        });


        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Validasi Skrinning
                $skrinning = DataSkrinning::findOne($model->skrinning_id);
                if (!$skrinning) {
                    throw new Exception('Data skrining tidak ditemukan.');
                }

                // Set pasien_id dari skrining
                $model->skrinning_id = $skrinning->id;
                $model->status = 1;

                if (!$model->save()) {
                    throw new Exception('Gagal menyimpan rekam medis.');
                }

                // Simpan layanan medis ke rekam_medis_detail
                $layananMedis = Yii::$app->request->post('layanan_medis', []);
                foreach ($layananMedis as $layanan_id) {
                    $layanan = LayananMedis::findOne($layanan_id);
                    if (!$layanan) {
                        throw new Exception('Layanan medis tidak ditemukan.');
                    }
                    $detail = new RekamMedisDetail();
                    $detail->rekam_medis_id = $model->id;
                    $detail->layanan_id = $layanan_id;
                    $detail->biaya = $layanan->biaya;
                    if (!$detail->save()) {
                        $transaction->rollBack(); // Rollback jika ada kesalahan
                        throw new Exception('Gagal menyimpan detail layanan medis.');
                    }
                }

                // Simpan resep obat ke DataResepDetail
                $obatIds = Yii::$app->request->post('obat_id', []);
                $jumlahObat = Yii::$app->request->post('jumlah', []);
                $dosisObat = Yii::$app->request->post('dosis', []);
                $instruksiObat = Yii::$app->request->post('instruksi', []);
                $biayaObat = Yii::$app->request->post('biaya', []);

                foreach ($obatIds as $obat_id) {
                    $obat = DataObat::findOne($obat_id);

                    if (!$obat) {
                        throw new Exception('Obat tidak ditemukan.');
                    }

                    if ($obat->persediaan < $jumlahObat[$obat_id]) {
                        throw new Exception("Stok obat '{$obat->nama}' tidak mencukupi. Sisa stok: {$obat->persediaan}");
                    }

                    $resep = new DataResepDetail();
                    $resep->rekam_medis_id = $model->id;
                    $resep->obat_id = $obat_id;
                    $resep->jumlah = $jumlahObat[$obat_id] ?? 1;
                    $resep->dosis = $dosisObat[$obat_id] ?? '';
                    $resep->instruksi = $instruksiObat[$obat_id] ?? '';
                    $resep->biaya = $biayaObat[$obat_id] ?? ($obat->harga_per_unit * $resep->jumlah);

                    if (!$resep->save()) {
                        $transaction->rollBack();
                        throw new Exception('Gagal menyimpan resep obat.');
                    }

                    // Kurangi stok obat
                    $obat->persediaan -= $jumlahObat[$obat_id];
                    if (!$obat->save()) {
                        $transaction->rollBack();
                        throw new Exception('Gagal memperbarui stok obat.');
                    }
                }

                $skrinning->status = 2;
                if (!$skrinning->save()) {
                    $transaction->rollBack();
                    throw new Exception('Gagal memperbarui status skrining.');
                }
                

                $transaction->commit(); // Commit transaksi jika semua sukses
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (Exception $e) {
                $transaction->rollBack(); // Rollback jika ada kesalahan
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $model,
            'skrinningDropdown' => $skrinningDropdown,
            'layananList' => ArrayHelper::map(LayananMedis::find()->all(), 'id', 'layanan'),
            'obatList' => ArrayHelper::map(DataObat::find()->all(), 'id', function ($obat) {
                return ['nama' => $obat->nama, 'harga' => $obat->harga_per_unit];
            }),
        ]);
    }


    //get data skrinning
    public function actionGetSkrinning($skrinning_id)
    {
        $skrinning = DataSkrinning::find()->where(['id' => $skrinning_id])->one();

        if ($skrinning) {
            return json_encode([
                'pendaftaran_id' => $skrinning->pendaftaran_id,
                'tinggi' => $skrinning->tinggi,
                'berat' => $skrinning->berat,
                'tekanan_darah' => $skrinning->tekanan_darah,
                'suhu' => $skrinning->suhu,
                'denyut_jantung' => $skrinning->denyut_jantung,
                'saturasi_oksigen' => $skrinning->saturasi_oksigen,
                'catatan' => $skrinning->catatan,
            ]);
        } else {
            return json_encode([]);
        }
    }


    /**
     * Updates an existing DataRekamMedis model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = DataRekamMedis::findOne($id);

        if (!$model) {
            Yii::$app->session->setFlash('error', 'Rekam medis tidak ditemukan.');
            return $this->redirect(['index']);
        }

        // Pastikan user login dan memiliki pegawai
        $data_pegawai = User::find()
            ->joinWith('pegawai')
            ->where(['user.id' => Yii::$app->user->id])
            ->one();

        if (!$data_pegawai || !$data_pegawai->pegawai) {
            Yii::$app->session->setFlash('error', 'Anda tidak memiliki data pegawai.');
            return $this->redirect(['index']);
        }

        // Ambil daftar skrining sesuai poli dokter yang login
        $skrinningList = DataSkrinning::find()
            ->joinWith('pendaftaran.pegawai')
            ->where(['data_pegawai.poli_id' => $data_pegawai->pegawai->poli_id])
            ->andWhere(['data_skrinning.status' => 1])
            ->all();

        $skrinningDropdown = ArrayHelper::map($skrinningList, 'id', function ($skrinning) {
            return $skrinning->pendaftaran->pasien->nama;
        });

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Validasi Skrinning
                $skrinning = DataSkrinning::findOne($model->skrinning_id);
                if (!$skrinning) {
                    throw new Exception('Data skrining tidak ditemukan.');
                }

                // Set pasien_id dari skrining
                $model->skrinning_id = $skrinning->id;
                $model->status = 1;

                if (!$model->save()) {
                    throw new Exception('Gagal memperbarui rekam medis.');
                }

                // Mengupdate layanan medis jika ada perubahan atau menghapus jika ada tombol delete
                $layananMedis = Yii::$app->request->post('layanan_medis', []);
                $layananMedisHapus = Yii::$app->request->post('layanan_medis_hapus', []); // Tombol hapus

                // Hapus layanan medis yang dipilih
                if (!empty($layananMedisHapus)) {
                    RekamMedisDetail::deleteAll(['rekam_medis_id' => $model->id, 'layanan_id' => $layananMedisHapus]);
                }

                // Menambahkan layanan medis baru
                foreach ($layananMedis as $layanan_id) {
                    // Mengecek apakah layanan medis sudah ada, jika tidak, tambahkan
                    $existingLayanan = RekamMedisDetail::find()
                        ->where(['rekam_medis_id' => $model->id, 'layanan_id' => $layanan_id])
                        ->one();

                    if (!$existingLayanan) {
                        $layanan = LayananMedis::findOne($layanan_id);
                        if (!$layanan) {
                            throw new Exception('Layanan medis tidak ditemukan.');
                        }

                        $detail = new RekamMedisDetail();
                        $detail->rekam_medis_id = $model->id;
                        $detail->layanan_id = $layanan_id;
                        $detail->biaya = $layanan->biaya;
                        if (!$detail->save()) {
                            $transaction->rollBack(); // Rollback jika ada kesalahan
                            throw new Exception('Gagal menyimpan detail layanan medis.');
                        }
                    }
                }

                // Mengupdate resep obat jika ada perubahan atau menghapus jika ada tombol delete
                $obatIds = Yii::$app->request->post('obat_id', []);
                $jumlahObat = Yii::$app->request->post('jumlah', []);
                $dosisObat = Yii::$app->request->post('dosis', []);
                $instruksiObat = Yii::$app->request->post('instruksi', []);
                $biayaObat = Yii::$app->request->post('biaya', []);
                $obatHapus = Yii::$app->request->post('obat_hapus', []); // Tombol hapus untuk obat

                // Hapus resep obat yang dipilih
                if (!empty($obatHapus)) {
                    DataResepDetail::deleteAll(['rekam_medis_id' => $model->id, 'obat_id' => $obatHapus]);
                }

                // Menambahkan resep obat baru
                foreach ($obatIds as $obat_id) {
                    $obat = DataObat::findOne($obat_id);

                    if (!$obat) {
                        throw new Exception('Obat tidak ditemukan.');
                    }

                    if ($obat->persediaan < $jumlahObat[$obat_id]) {
                        throw new Exception("Stok obat '{$obat->nama}' tidak mencukupi. Sisa stok: {$obat->persediaan}");
                    }

                    $existingResep = DataResepDetail::find()
                        ->where(['rekam_medis_id' => $model->id, 'obat_id' => $obat_id])
                        ->one();

                    if (!$existingResep) {
                        $resep = new DataResepDetail();
                        $resep->rekam_medis_id = $model->id;
                        $resep->obat_id = $obat_id;
                        $resep->jumlah = $jumlahObat[$obat_id] ?? 1;
                        $resep->dosis = $dosisObat[$obat_id] ?? '';
                        $resep->instruksi = $instruksiObat[$obat_id] ?? '';
                        $resep->biaya = $biayaObat[$obat_id] ?? ($obat->harga_per_unit * $resep->jumlah);

                        if (!$resep->save()) {
                            $transaction->rollBack();
                            throw new Exception('Gagal memperbarui resep obat.');
                        }

                        // Kurangi stok obat
                        $obat->persediaan -= $jumlahObat[$obat_id];
                        if (!$obat->save()) {
                            $transaction->rollBack();
                            throw new Exception('Gagal memperbarui stok obat.');
                        }
                    }
                }
                $transaction->commit(); // Commit transaksi jika semua sukses
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (Exception $e) {
                $transaction->rollBack(); // Rollback jika ada kesalahan
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $model,
            'skrinningDropdown' => $skrinningDropdown,
            'layananList' => ArrayHelper::map(LayananMedis::find()->all(), 'id', 'layanan'),
            'obatList' => ArrayHelper::map(DataObat::find()->all(), 'id', function ($obat) {
                return ['nama' => $obat->nama, 'harga' => $obat->harga_per_unit];
            }),
        ]);
    }



    /**
     * Deletes an existing DataRekamMedis model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DataRekamMedis model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return DataRekamMedis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataRekamMedis::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
