<?php

namespace app\controllers;

use Yii;
use app\models\DataPegawai;
use app\models\search\DataPegawaiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * DataPegawaiController implements the CRUD actions for DataPegawai model.
 */
class DataPegawaiController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulkdelete' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        $this->layout = 'theme/main';
    }

    /**
     * Lists all DataPegawai models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataPegawaiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single DataPegawai model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "DataPegawai #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                    Html::a(Yii::t('yii2-ajaxcrud', 'Update'), ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new DataPegawai model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new DataPegawai();
        $model_kecamatan = new \yii\base\DynamicModel(['kecamatan_id']);
        $model_kecamatan->addRule(['kecamatan_id'], 'safe')->setAttributeLabels(['kecamatan_id' => 'Kecamatan']);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($request->isGet) {
                return $this->renderAjaxResponse('Create New DataPasien', $model, $model_kecamatan);
            }

            if ($model->load($request->post()) && $model_kecamatan->load($request->post()) && $model_kecamatan->validate()) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($model->validate() && $model->save()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', "Data Berhasil Disimpan.");
                        return ['forceReload' => '#crud-datatable-pjax'] + $this->successResponse();
                    }
                    $transaction->rollBack();
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            return $this->renderAjaxResponse('Create New DataPasien', $model, $model_kecamatan);
        }

        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', compact('model', 'model_kecamatan'));
    }

    private function renderAjaxResponse($title, $model, $model_kecamatan)
    {
        return [
            'title' => Yii::t('yii2-ajaxcrud', $title),
            'content' => $this->renderAjax('create', compact('model', 'model_kecamatan')),
            'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                Html::button(Yii::t('yii2-ajaxcrud', 'Save'), ['class' => 'btn btn-primary', 'type' => 'submit'])
        ];
    }

    private function successResponse()
    {
        return [
            'title' => Yii::t('yii2-ajaxcrud', 'Create New DataPasien'),
            'content' => '<span class="text-success">' . Yii::t('yii2-ajaxcrud', 'Create DataPasien Success') . '</span>',
            'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                Html::a(Yii::t('yii2-ajaxcrud', 'Create More'), ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
        ];
    }

    /**
     * Updates an existing DataPegawai model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        $model_kecamatan = new \yii\base\DynamicModel(['kecamatan_id']);
        $model_kecamatan->addRule(['kecamatan_id'], 'safe');
        $model_kecamatan->setAttributeLabels(['kecamatan_id' => 'Kecamatan']);
        $model_kecamatan->kecamatan_id = $model->kelurahan->kecamatan_id;

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($request->isGet) {
                return $this->renderAjaxResponse('update', $model, $model_kecamatan);
            }

            if ($model->load($request->post()) && $model_kecamatan->load($request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($model->validate() && $model->save()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', "Data Berhasil Disimpan.");
                        return $this->successResponse($model);
                    }
                    $transaction->rollBack();
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
            }

            return $this->renderAjaxResponse('update', $model, $model_kecamatan);
        }

        return $this->render('update', compact('model', 'model_kecamatan'));
    }

    /**
     * Delete an existing DataPegawai model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    public function actionGetKelurahanJson()
    {
        $out = [];

        if (isset($_POST['depdrop_all_params'])) {
            $parents = $_POST['depdrop_all_params'];

            if ($parents != null) {
                $out = \app\models\WilayahKelurahan::find()
                    ->andWhere(['kecamatan_id' => $parents['kecamatan_id']])
                    ->select(["id AS id", "kelurahan AS name"])->asArray()->all();

                return Json::encode(['output' => $out, 'selected' => '']);
            } else {
                return Json::encode(['output' => '', 'selected' => '']);
            }
        }
    }


    /**
     * Delete multiple existing DataPegawai model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the DataPegawai model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DataPegawai the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataPegawai::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
