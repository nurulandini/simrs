<?php

namespace app\controllers;

use app\models\DataResepDetail;
use app\models\search\DataResepDetailSearch;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DataResepDetailController implements the CRUD actions for DataResepDetail model.
 */
class DataResepDetailController extends Controller
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
     * Lists all DataResepDetail models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DataResepDetailSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        // Ambil semua data resep
        $resep = DataResepDetail::find()->all();

        // Proses Grouping
        $groupedResep = [];
        foreach ($resep as $item) {
            $rekam_medis_id = $item->rekam_medis_id;

            if (!isset($groupedResep[$rekam_medis_id])) {
                $groupedResep[$rekam_medis_id] = [
                    'pasien' => $item->rekamMedis->skrinning->pendaftaran->pasien,
                    'pegawai' => $item->rekamMedis->skrinning->pendaftaran->pegawai,
                    'poli' => $item->rekamMedis->skrinning->pendaftaran->pegawai->poli,
                    'resep' => [],
                ];
            }

            $groupedResep[$rekam_medis_id]['resep'][] = [
                'id' => $item->id,
                'nama_obat' => $item->obat->nama,
                'jumlah' => $item->jumlah,
                'dosis' => $item->dosis,
                'biaya' => $item->biaya,
                'status' => $item->status,
                'updated_at' => $item->updated_at,
            ];
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'groupedResep' => $groupedResep,
        ]);
    }

    /**
     * Displays a single DataResepDetail model.
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

    public function actionKonfirmasi($id)
    {


        $model = DataResepDetail::findOne($id);
        // Pastikan user login dan memiliki pegawai
        $data_pegawai = User::find()
            ->joinWith('pegawai')
            ->where(['user.id' => Yii::$app->user->id])
            ->one();

        if (!$data_pegawai || !$data_pegawai->pegawai) {
            Yii::$app->session->setFlash('error', 'Anda tidak memiliki akses untuk ini.');
            return $this->redirect(['index']);
        }

        if ($model !== null) {
            $model->updated_by = Yii::$app->user->identity->id;;
            $model->status = 1; // Ubah status menjadi 'Dikonfirmasi'
            $model->save(false);
        }

        return $this->redirect(['index']);
    }

    /**
     * Creates a new DataResepDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DataResepDetail();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DataResepDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DataResepDetail model.
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
     * Finds the DataResepDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return DataResepDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataResepDetail::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
