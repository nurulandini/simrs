<?php

namespace app\controllers;

use app\models\DataPendaftaranPasien;
use app\models\DataSkrinning;
use app\models\search\DataSkrinningSearch;
use app\models\User;
use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DataSkrinningController implements the CRUD actions for DataSkrinning model.
 */
class DataSkrinningController extends Controller
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
     * Lists all DataSkrinning models.
     *
     * @return string
     */
    // public function actionIndex()
    // {
    //     $searchModel = new DataSkrinningSearch();
    //     $dataProvider = $searchModel->search($this->request->queryParams);

    //     $loggedInUserId = Yii::$app->user->identity->id;
    //     $data_pegawai = User::findOne($loggedInUserId);

    //     if ($data_pegawai) {
    //         $poli_id = $data_pegawai->pegawai->poli_id; // Sesuaikan dengan field poli di tabel User

    //         // **Filter langsung di dataProvider**
    //         $dataProvider = new ActiveDataProvider([
    //             'query' => DataSkrinning::find()->joinWith('pendaftaran.pegawai')->where(['data_pegawai.poli_id' => $poli_id]),
    //         ]);
    //     } else {
    //         // Jika tidak ada poli_id, tetap tampilkan semua data
    //         $dataProvider = new ActiveDataProvider([
    //             'query' => DataSkrinning::find(),
    //         ]);
    //     }

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    public function actionIndex()
    {
        $searchModel = new DataSkrinningSearch();

        $loggedInUserId = Yii::$app->user->identity->id;
        $data_pegawai = User::findOne($loggedInUserId);


        if ($data_pegawai && $data_pegawai->pegawai) {
            $poli_id = $data_pegawai->pegawai->poli_id ?? null;

            // Jika poli_id ada, filter berdasarkan poli_id
            if ($poli_id) {
                $searchModel->poli_id = $poli_id;
            }
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DataSkrinning model.
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
     * Creates a new DataSkrinning model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DataSkrinning();
        // Pastikan user login dan memiliki pegawai
        $data_pegawai = User::find()
            ->joinWith('pegawai')
            ->where(['user.id' => Yii::$app->user->id])
            ->one();

        if (!$data_pegawai || !$data_pegawai->pegawai) {
            Yii::$app->session->setFlash('error', 'Anda tidak memiliki akses untuk ini.');
            return $this->redirect(['index']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($model->load($this->request->post())) {
                $model->pegawai_id = $data_pegawai->pegawai_id;
                $model->status = 1;

                if (!$model->save()) {
                    throw new Exception("Gagal menyimpan DataSkrinning: " . json_encode($model->errors));
                }

                if ($model->pendaftaran) {
                    $model->pendaftaran->status = 2;
                    if (!$model->pendaftaran->save()) {
                        throw new Exception("Gagal menyimpan perubahan status Pendaftaran: " . json_encode($model->pendaftaran->errors));
                    }
                }

                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage());
            Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DataSkrinning model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->status == 0) {
            Yii::$app->session->setFlash('error', 'Data tidak dapat diubah karena statusnya sudah di Arsip.');
            return $this->redirect(['index']); // Kembali ke halaman utama
        }

        $pendaftaranData = DataPendaftaranPasien::find()
            ->joinWith('pasien pasien')
            ->select(['pasien.nama'])
            ->where(['data_pendaftaran_pasien.id' => $model->pendaftaran_id])
            ->column();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'pendaftaranData' => $pendaftaranData, // Kirim ke view
        ]);
    }

    /**
     * Deletes an existing DataSkrinning model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = DataSkrinning::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Data tidak ditemukan.');
        }

        // Cegah penghapusan jika status == 0
        if ($model->status == 0) {
            Yii::$app->session->setFlash('error', 'Data tidak dapat dihapus karena statusnya sudah di Arsip.');
            return $this->redirect(['index']); // Kembali ke halaman utama
        }

        $model->delete();
        Yii::$app->session->setFlash('success', 'Data berhasil dihapus.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the DataSkrinning model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return DataSkrinning the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataSkrinning::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
