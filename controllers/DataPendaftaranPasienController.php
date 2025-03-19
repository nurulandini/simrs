<?php

namespace app\controllers;

use app\models\DataPendaftaranPasien;
use app\models\search\DataPendaftaranPasienSearch;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DataPendaftaranPasienController implements the CRUD actions for DataPendaftaranPasien model.
 */
class DataPendaftaranPasienController extends Controller
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
     * Lists all DataPendaftaranPasien models.
     *
     * @return string
     */
    // public function actionIndex()
    // {
    //     $searchModel = new DataPendaftaranPasienSearch();
    //     $dataProvider = $searchModel->search($this->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    public function actionIndex()
    {
        $searchModel = new DataPendaftaranPasienSearch();
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

    /**
     * Displays a single DataPendaftaranPasien model.
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
     * Creates a new DataPendaftaranPasien model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {

        $request = Yii::$app->request;
        $model = new DataPendaftaranPasien();
        $model_poli = new \yii\base\DynamicModel(['poli_id']);
        $model_poli->addRule(['poli_id'], 'safe')->setAttributeLabels(['poli_id' => 'Poli']);


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model_poli->load($request->post()) && $model_poli->validate()) {
                $model->status = 1;
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'model_poli' => $model_poli
        ]);
    }

    /**
     * Updates an existing DataPendaftaranPasien model.
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

        $model_poli = new \yii\base\DynamicModel(['poli_id']);
        $model_poli->addRule(['poli_id'], 'safe');
        $model_poli->setAttributeLabels(['poli_id' => 'Poli']);
        $model_poli->poli_id = $model->pegawai->poli_id;


        if ($this->request->isPost && $model->load($this->request->post()) && $model_poli->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'model_poli' => $model_poli
        ]);
    }

    /**
     * Deletes an existing DataPendaftaranPasien model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = DataPendaftaranPasien::findOne($id);

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
     * Finds the DataPendaftaranPasien model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return DataPendaftaranPasien the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataPendaftaranPasien::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
