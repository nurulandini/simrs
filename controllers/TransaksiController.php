<?php

namespace app\controllers;

use app\models\DataRekamMedis;
use app\models\DataResepDetail;
use app\models\RekamMedisDetail;
use app\models\Transaksi;
use app\models\search\TransaksiSearch;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\ForbiddenHttpException;

/**
 * TransaksiController implements the CRUD actions for Transaksi model.
 */
class TransaksiController extends Controller
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
     * Lists all Transaksi models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TransaksiSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transaksi model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Transaksi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Transaksi();

        // Ambil semua rekam medis tanpa filter pegawai
        $rekamMedisList = DataRekamMedis::find()->where(['status' => 1])->all();

        // Buat dropdown untuk pasien berdasarkan rekam medis
        $rekamMedisDropdown = ArrayHelper::map($rekamMedisList, 'id', function ($rekamMedis) {
            return $rekamMedis->skrinning->pendaftaran->pasien->nama;
        });

        if ($this->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->load($this->request->post())) {
                    // Ambil rekam medis berdasarkan ID yang dipilih
                    $rekamMedis = DataRekamMedis::findOne($model->rekam_medis_id);

                    if (!$rekamMedis) {
                        throw new Exception('Rekam medis tidak ditemukan.');
                    }

                    // Ubah status skrinning dan pendaftaran
                    $rekamMedis->status = 0;
                    $rekamMedis->skrinning->status = 0;
                    $rekamMedis->skrinning->pendaftaran->status = 0;

                    if (!$rekamMedis->save(false)) {
                        $transaction->rollBack(); // Batalkan jika ada kesalahan
                        throw new Exception('Gagal memperbarui status skrining.');
                    }

                    if (!$rekamMedis->skrinning->save(false)) {
                        $transaction->rollBack(); // Batalkan jika ada kesalahan
                        throw new Exception('Gagal memperbarui status skrining.');
                    }

                    if (!$rekamMedis->skrinning->pendaftaran->save(false)) {
                        $transaction->rollBack(); // Batalkan jika ada kesalahan
                        throw new Exception('Gagal memperbarui status pendaftaran.');
                    }

                    // Simpan transaksi
                    if (!$model->save()) {
                        $transaction->rollBack(); // Batalkan jika ada kesalahan
                        throw new Exception('Gagal menyimpan transaksi.');
                    }

                    $transaction->commit(); // Commit jika semua berhasil
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\Exception $e) {
                $transaction->rollBack(); // Batalkan jika ada kesalahan
                Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'rekamMedisDropdown' => $rekamMedisDropdown,
        ]);
    }


    public function actionGetRekamMedisDetail($id)
    {
        $rekamMedis = DataRekamMedis::findOne($id);

        if ($rekamMedis) {
            // Ambil hasil diagnosa
            $hasilDiagnosa = Html::decode($rekamMedis->diagnosa);
            // Ambil layanan medis
            $layanan = RekamMedisDetail::find()
                ->joinWith('layanan') // Pastikan relasi ke layanan
                ->where(['rekam_medis_id' => $id])
                ->select(['rekam_medis_detail.*', 'layanan_medis.layanan AS nama_layanan'])
                ->asArray()
                ->all();

            // Ambil resep obat beserta nama obat
            $resep = DataResepDetail::find()
                ->joinWith('obat') // Pastikan relasi ke obat
                ->where(['rekam_medis_id' => $id])
                ->select(['data_resep_detail.*', 'data_obat.nama AS nama_obat'])
                ->asArray()
                ->all();

            // Hitung biaya layanan dan obat
            $biayaLayanan = RekamMedisDetail::find()->where(['rekam_medis_id' => $id])->sum('biaya') ?? 0;
            $biayaObat = DataResepDetail::find()->where(['rekam_medis_id' => $id])->sum('biaya') ?? 0;

            return json_encode([
                'diagnosa' => $hasilDiagnosa,
                'layanan' => $layanan,
                'resep' => $resep,
                'biaya_layanan' => $biayaLayanan,
                'biaya_obat' => $biayaObat,
                'total_harga' => $biayaLayanan + $biayaObat
            ]);
        }

        return json_encode(['error' => 'Data tidak ditemukan']);
    }


    /**
     * Updates an existing Transaksi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateStatus($id)
    {
        $model = Transaksi::findOne($id);

        if (!$model || $model->status_pembayaran == 1) {
            throw new NotFoundHttpException('Transaksi tidak ditemukan atau sudah lunas.');
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->status_pembayaran = 1; // Set menjadi lunas
                if ($model->save()) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Status pembayaran berhasil diperbarui.');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

        return $this->render('update-status', [
            'model' => $model,
        ]);
    }

    public function actionCetakStruk($id)
    {
        $model = Transaksi::find()
            ->where(['transaksi.id' => $id])
            ->joinWith([
                'rekamMedis rm',
                'rekamMedis.skrinning.pendaftaran.pasien p',
                'rekamMedis.rekamMedisDetails rmd',
                'rekamMedis.rekamMedisDetails.layanan lyn',
            ])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException("Data transaksi tidak ditemukan.");
        }

        if ($model->status_pembayaran != 1) {
            throw new ForbiddenHttpException("Struk hanya bisa dicetak jika pembayaran sudah lunas.");
        }

        return $this->renderPartial('cetak-struk', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Transaksi model.
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
     * Finds the Transaksi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Transaksi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaksi::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
