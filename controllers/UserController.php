<?php

namespace app\controllers;

use app\models\ChangePassword as ModelsChangePassword;
use app\models\ChangePasswordProfil as ModelsChangePasswordProfil;
use app\models\DataLsm;
use app\models\DataLsmFile;
use app\models\DataMasyarakat;
use app\models\DataMasyarakatFile;
use app\models\DataPerusahaan;
use app\models\DataPerusahaanFile;
use app\models\DataPerusahaanSosialMedia;
use Yii;
use app\models\User;
use app\models\search\UserSearch;
use app\models\UploadFileDataLsm;
use app\models\UploadFileDataMasyarakat;
use app\models\UploadFileDataPerusahaan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'theme/main';
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy(['created_at' => SORT_DESC]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUserVerifikasi()
    {
        $this->layout = 'theme/main';
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andwhere(['not', ['user.perusahaan_id' => NULL]])->orderBy(['created_at' => SORT_DESC]);
        $dataProvider1 = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider1->query->andwhere(['not', ['user.lsm_id' => NULL]])->orderBy(['created_at' => SORT_DESC]);
        $dataProvider2 = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider2->query->andwhere(['not', ['user.masyarakat_id' => NULL]])->orderBy(['created_at' => SORT_DESC]);
        $dataProvider3 = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider3->query->andwhere(['not', ['user.subunit_id' => NULL]])->orderBy(['created_at' => SORT_DESC]);

        return $this->render('verifikasi/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProvider1' => $dataProvider1,
            'dataProvider2' => $dataProvider2,
            'dataProvider3' => $dataProvider3,
        ]);
    }

    public function actionProfil()
    {
        $id = Yii::$app->user->getId();
        $model = $this->findModel($id);
        
        return $this->render('profil', [
            'model' => $model,
        ]);
    }


    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->manage->roleCheck("admin_sistem") || Yii::$app->manage->roleCheck("Operator")) {
            $model = $this->findModel($id);
        } elseif (Yii::$app->manage->roleCheck("Perusahaan")) {
            $model = User::find()->where(['id' => $id])->andWhere(['not', ['perusahaan_id' => null]])->one();
            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan mengintip isinya.');
            }
        } elseif (Yii::$app->manage->roleCheck("Umkm")) {
            $model = User::find()->where(['id' => $id])->andWhere(['not', ['masyarakat_id' => null]])->one();
            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan mengintip isinya.');
            }
        } elseif (Yii::$app->manage->roleCheck("Lsm")) {
            $model = User::find()->where(['id' => $id])->andWhere(['not', ['lsm_id' => null]])->one();
            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan mengintip isinya.');
            }
        } elseif (Yii::$app->manage->roleCheck("Opd")) {
            $model = User::find()->where(['id' => $id])->andWhere(['not', ['subunit_id' => null]])->one();
            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan mengintip isinya.');
            }
        }

        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "User #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $model,
                ]),
                'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a(Yii::t('yii2-ajaxcrud', 'Update'), ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new User model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new User();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " User",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Create'), ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            } else if ($model->load($request->post())) {
                $model->setPassword($model->password_hash);
                $model->generateAuthKey();
                $model->created_at = time();
                $model->updated_at = time();
                $auth = \Yii::$app->authManager;
                $role = $auth->getRole($this->request->post('role'));

                $hasil = '<span class="text-success">' . Yii::t('yii2-ajaxcrud', 'Create') . ' User ' . Yii::t('yii2-ajaxcrud', 'Success') . '</span>';
                if ($role) {
                    if (!$model->save()) {
                        $hasil = '<span class="text-danger">' . Yii::t('yii2-ajaxcrud', 'Create') . ' User ' . Yii::t('yii2-ajaxcrud', 'Fail') . '</span><br><pre>.' . print_r($model->errors) . '</pre>';
                    } else {
                        // $role = $auth->getRole('admin');
                        // print_r($role);
                        // echo '<br>';
                        // echo $model->getId();
                        // die;
                        $auth->assign($role, $model->getId());
                    }
                } else {
                    $hasil = "<span class='text-danger'> Role tidak valid </span>";
                }

                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " User",
                    // 'content'=>'<span class="text-success">'.Yii::t('yii2-ajaxcrud', 'Create').' User '.Yii::t('yii2-ajaxcrud', 'Success').'</span>',
                    'content' => $hasil,
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::a(Yii::t('yii2-ajaxcrud', 'Create More'), ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])

                ];
            } else {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " User",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing User model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        if (Yii::$app->manage->roleCheck("admin_sistem") || Yii::$app->manage->roleCheck("Operator")) {
            $model = $this->findModel($id);
        } elseif (Yii::$app->manage->roleCheck("Perusahaan")) {
            $model = User::find()->where(['id' => $id])->andWhere(['not', ['perusahaan_id' => null]])->one();
            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan mengintip isinya.');
            }
        } elseif (Yii::$app->manage->roleCheck("Umkm")) {
            $model = User::find()->where(['id' => $id])->andWhere(['not', ['masyarakat_id' => null]])->one();
            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan mengintip isinya.');
            }
        } elseif (Yii::$app->manage->roleCheck("Lsm")) {
            $model = User::find()->where(['id' => $id])->andWhere(['not', ['lsm_id' => null]])->one();
            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan mengintip isinya.');
            }
        } elseif (Yii::$app->manage->roleCheck("Opd")) {
            $model = User::find()->where(['id' => $id])->andWhere(['not', ['subunit_id' => null]])->one();
            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan mengintip isinya.');
            }
        }

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Update') . " User #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "User #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::a(Yii::t('yii2-ajaxcrud', 'Update'), ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Update') . " User #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing User model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        if (Yii::$app->manage->roleCheck("admin_sistem") || Yii::$app->manage->roleCheck("Operator")) {
            $this->findModel($id)->delete();
        } elseif (Yii::$app->manage->roleCheck("Perusahaan")) {
            $model = User::find()->where(['id' => $id])->andWhere(['not', ['perusahaan_id' => null]])->one();
            $model->delete();
            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan menghapus data ini !');
            }
        } elseif (Yii::$app->manage->roleCheck("Lsm")) {
            $model = User::find()->where(['id' => $id])->andWhere(['not', ['lsm_id' => null]])->one();
            $model->delete();
            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan menghapus data ini !');
            }
        } elseif (Yii::$app->manage->roleCheck("Umkm")) {
            $model = User::find()->where(['id' => $id])->andWhere(['not', ['masyarakat_id' => null]])->one();
            $model->delete();
            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan menghapus data ini !');
            }
        } elseif (Yii::$app->manage->roleCheck("Opd")) {
            $model = User::find()->where(['id' => $id])->andWhere(['not', ['subunit_id' => null]])->one();
            $model->delete();
            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan menghapus data ini !');
            }
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
     * Delete multiple existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionChangePassword()
    {
        $model = new ModelsChangePasswordProfil();

        if ($model->load(Yii::$app->request->post()) && $model->resetPassword()) {
            \Yii::$app->session->addFlash('success', 'Password berhasil diubah !');
            return $this->refresh();
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

    public function actionChangePasswordUser($id = null)
    {
        if (!$id) {
            $id = Yii::$app->user->id;
        }
        $user = User::findOne($id);
        $model = new ModelsChangePassword();
        $request = Yii::$app->request;

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Ganti Password",
                    'content' => $this->renderAjax('change-password-user', [
                        'model' => $model,
                        'user' => $user,
                    ]),
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load(Yii::$app->getRequest()->post()) && $model->change($user)) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Ganti Password",
                    'content' => '<span class="text-success">Ganti Password Berhasil</span>',
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])

                ];
            } else {
                return [
                    'title' => "Ganti Password",
                    'content' => $this->renderAjax('change-password-user', [
                        'model' => $model,
                        'user' => $user,
                    ]),
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        } else {
        }
    }

    public function actionVerifikasiUser($id)
    {

        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model_perusahaan = DataPerusahaan::find()->where(['id' => $model->perusahaan_id])->one();
        $model_lsm = DataLsm::find()->where(['id' => $model->lsm_id])->one();
        $model_umkm = DataMasyarakat::find()->where(['id' => $model->masyarakat_id])->one();



        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                if ($model->perusahaan_id) {
                    if ($model->status == 0) {
                        $model->status = 10;
                        $model_perusahaan->status = 1;
                        $model_perusahaan->save();
                    } else {
                        $model->status = 0;
                        $model_perusahaan->status = 0;
                        $model_perusahaan->save();
                    }
                } elseif ($model->masyarakat_id) {
                    if ($model->status == 0) {
                        $model->status = 10;
                        $model_umkm->status = 1;
                        $model_umkm->save();
                    } else {
                        $model->status = 0;
                        $model_umkm->status = 0;
                        $model_umkm->save();
                    }
                } elseif ($model->lsm_id) {
                    if ($model->status == 0) {
                        $model->status = 10;
                        $model_lsm->status = 1;
                        $model_lsm->save();
                    } else {
                        $model->status = 0;
                        $model_lsm->status = 0;
                        $model_lsm->save();
                    }
                }
                $model->save();

                if ($model->status == 10) {
                    if ($model->perusahaan_id) {
                        return [
                            'forceReload' => '#crud-datatable-pjax',
                            'title' => "Berhasil Diverifikasi",
                            'content' => "Akun diaktifkan !!!",
                            'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]),
                            Yii::$app->mailer
                                ->compose(
                                    ['html' => 'verifkasiAkun-html', 'text' => 'verifkasiAkun-text'],
                                    ['model' => $model, 'app_name' => Yii::$app->name]
                                )
                                ->setFrom([Yii::$app->params['adminEmail'] => 'Bappeda Kota Medan'])
                                ->setTo($model->email)
                                ->setSubject('Verifkasi Pendaftaran akun CSR Pemerintah Kota Medan')
                                ->send()
                        ];
                    } elseif ($model->masyarakat_id) {
                        return [
                            'forceReload' => '#crud-datatableumkm-pjax',
                            'title' => "Berhasil Diverifikasi",
                            'content' => "Akun diaktifkan !!!",
                            'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]),
                            Yii::$app->mailer
                                ->compose(
                                    ['html' => 'verifkasiAkun-html', 'text' => 'verifkasiAkun-text'],
                                    ['model' => $model, 'app_name' => Yii::$app->name]
                                )
                                ->setFrom([Yii::$app->params['adminEmail'] => 'Bappeda Kota Medan'])
                                ->setTo($model->email)
                                ->setSubject('Verifkasi Pendaftaran akun CSR Pemerintah Kota Medan')
                                ->send()
                        ];
                    } elseif ($model->lsm_id) {
                        return [
                            'forceReload' => '#crud-datatablelsm-pjax',
                            'title' => "Berhasil Diverifikasi",
                            'content' => "Akun diaktifkan !!!",
                            'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]),
                            Yii::$app->mailer
                                ->compose(
                                    ['html' => 'verifkasiAkun-html', 'text' => 'verifkasiAkun-text'],
                                    ['model' => $model, 'app_name' => Yii::$app->name]
                                )
                                ->setFrom([Yii::$app->params['adminEmail'] => 'Bappeda Kota Medan'])
                                ->setTo($model->email)
                                ->setSubject('Verifkasi Pendaftaran akun CSR Pemerintah Kota Medan')
                                ->send()
                        ];
                    }
                } elseif ($model->status == 0) {
                    if ($model->perusahaan_id) {
                        return [
                            'forceReload' => '#crud-datatable-pjax',
                            'title' => "Berhasil Dinon-aktifkan",
                            'content' => "Akun dinon-aktifkan !!!",
                            'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]),
                            Yii::$app->mailer
                                ->compose(
                                    ['html' => 'nonaktifAkun-html', 'text' => 'nonaktifAkun-text'],
                                    ['model' => $model, 'app_name' => Yii::$app->name]
                                )
                                ->setFrom([Yii::$app->params['adminEmail'] => 'Bappeda Kota Medan'])
                                ->setTo($model->email)
                                ->setSubject('Pemberitahuan Akun diNonaktifkan.')
                                ->send()
                        ];
                    } elseif ($model->lsm_id) {
                        return [
                            'forceReload' => '#crud-datatablelsm-pjax',
                            'title' => "Berhasil Dinon-aktifkan",
                            'content' => "Akun dinon-aktifkan !!!",
                            'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]),
                            Yii::$app->mailer
                                ->compose(
                                    ['html' => 'nonaktifAkun-html', 'text' => 'nonaktifAkun-text'],
                                    ['model' => $model, 'app_name' => Yii::$app->name]
                                )
                                ->setFrom([Yii::$app->params['adminEmail'] => 'Bappeda Kota Medan'])
                                ->setTo($model->email)
                                ->setSubject('Pemberitahuan Akun diNonaktifkan.')
                                ->send()
                        ];
                    } elseif ($model->masyarakat_id) {
                        return [
                            'forceReload' => '#crud-datatableumkm-pjax',
                            'title' => "Berhasil Dinon-aktifkan",
                            'content' => "Akun dinon-aktifkan !!!",
                            'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]),
                            Yii::$app->mailer
                                ->compose(
                                    ['html' => 'nonaktifAkun-html', 'text' => 'nonaktifAkun-text'],
                                    ['model' => $model, 'app_name' => Yii::$app->name]
                                )
                                ->setFrom([Yii::$app->params['adminEmail'] => 'Bappeda Kota Medan'])
                                ->setTo($model->email)
                                ->setSubject('Pemberitahuan Akun diNonaktifkan.')
                                ->send()
                        ];
                    }
                }
            } else {
                return $this->redirect(['index']);
            }
        }
    }

    public function actionUbahProfil()
    {
        if (Yii::$app->manage->roleCheck("Perusahaan")) {
            $model = User::find()->where(['id' => Yii::$app->user->getId()])->andWhere(['not', ['perusahaan_id' => null]])->one();
            $model_perusahaan = DataPerusahaan::find()->where(['id' => $model->perusahaan_id])->one();
            $file_logo = DataPerusahaanFile::find()->where(['perusahaan_id' => $model_perusahaan->id])->andWhere(['keterangan' => "logo"])->all();
            $file_npwp_perusahaan = DataPerusahaanFile::find()->where(['perusahaan_id' => $model_perusahaan->id])->andWhere(['keterangan' => "npwp_perusahaan"])->all();
            $model_upload_file1 = new UploadFileDataPerusahaan();
            $model_sosmed_old = DataPerusahaanSosialMedia::findAll(['perusahaan_id' => $model_perusahaan->id]);
            $model_sosmed = new DataPerusahaanSosialMedia();
            $model_kecamatan = new \yii\base\DynamicModel(['kecamatan_id']);
            $model_kecamatan->addRule(['kecamatan_id'], 'safe');
            $model_kecamatan->addRule(['kecamatan_id'], 'required');
            $model_kecamatan->setAttributeLabels(['kecamatan_id' => 'Kecamatan']);
            $model_kecamatan->kecamatan_id = $model_perusahaan->kelurahan->kecamatan_id;
            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan menghapus data ini !');
            }
        } elseif (Yii::$app->manage->roleCheck("Lsm")) {
            $model = User::find()->where(['id' => Yii::$app->user->getId()])->andWhere(['not', ['lsm_id' => null]])->one();
            $model_lsm = DataLsm::find()->where(['id' => $model->lsm_id])->one();
            $file_npwp_lsm = DataLsmFile::find()->where(['lsm_id' => $model_lsm->id])->andWhere(['keterangan' => "npwp"])->all();
            $model_upload_file2 = new UploadFileDataLsm();
            $model_kecamatan = new \yii\base\DynamicModel(['kecamatan_id']);
            $model_kecamatan->addRule(['kecamatan_id'], 'safe');
            $model_kecamatan->addRule(['kecamatan_id'], 'required');
            $model_kecamatan->setAttributeLabels(['kecamatan_id' => 'Kecamatan']);
            $model_kecamatan->kecamatan_id = $model_lsm->kelurahan->kecamatan_id;

            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan menghapus data ini !');
            }
        } elseif (Yii::$app->manage->roleCheck("Umkm")) {
            $model = User::find()->where(['id' => Yii::$app->user->getId()])->andWhere(['not', ['masyarakat_id' => null]])->one();
            $model_umkm = DataMasyarakat::find()->where(['id' => $model->masyarakat_id])->one();
            $file_ktp = DataMasyarakatFile::find()->where(['masyarakat_id' => $model_umkm->id])->andWhere(['keterangan' => "ktp"])->all();
            $file_npwp_umkm = DataMasyarakatFile::find()->where(['masyarakat_id' => $model_umkm->id])->andWhere(['keterangan' => "npwp"])->all();
            $model_upload_file3 = new UploadFileDataMasyarakat();
            $model_kecamatan = new \yii\base\DynamicModel(['kecamatan_id']);
            $model_kecamatan->addRule(['kecamatan_id'], 'safe');
            $model_kecamatan->addRule(['kecamatan_id'], 'required');
            $model_kecamatan->setAttributeLabels(['kecamatan_id' => 'Kecamatan']);
            $model_kecamatan->kecamatan_id = $model_umkm->kelurahan->kecamatan_id;
            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan menghapus data ini !');
            }
        } elseif (Yii::$app->manage->roleCheck("Opd")) {
            $model = User::find()->where(['id' => Yii::$app->user->getId()])->andWhere(['not', ['subunit_id' => null]])->one();
            if (!$model) {
                throw new ForbiddenHttpException('Anda tidak diperbolehkan menghapus data ini !');
            }
        }

        if ($this->request->isGet) {
            return $this->render('ubah-profil', [
                'model' => $model,
                'model_perusahaan' => isset($model_perusahaan) ? $model_perusahaan : null,
                'model_kecamatan' => isset($model_kecamatan) ? $model_kecamatan : null,
                'model_lsm' => isset($model_lsm) ? $model_lsm : null,
                'model_umkm' => isset($model_umkm) ? $model_umkm : null,
                'model_upload_file1' => isset($model_upload_file1) ? $model_upload_file1 : null,
                'model_upload_file2' => isset($model_upload_file2) ? $model_upload_file2 : null,
                'model_upload_file3' => isset($model_upload_file3) ? $model_upload_file3 : null,
                'model_sosmed' => isset($model_sosmed) ? $model_sosmed : null,
                'model_sosmed_old' => isset($model_sosmed_old) ? $model_sosmed_old : null,
                'file_logo' => isset($file_logo) ? $file_logo : null,
                'file_npwp_perusahaan' => isset($file_npwp_perusahaan) ? $file_npwp_perusahaan : null,
                'file_npwp_lsm' => isset($file_npwp_lsm) ? $file_npwp_lsm : null,
                'file_npwp_umkm' => isset($file_npwp_umkm) ? $file_npwp_umkm : null,
                'file_ktp' => isset($file_ktp) ? $file_ktp : null,
            ]);
        } elseif (isset($model_perusahaan) && $model_perusahaan->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if (!($flag = $model_perusahaan->validate() && $model_perusahaan->save())) {
                    $transaction->rollBack();
                    Yii::$app->session->addFlash('danger', 'Data perusahaan yang Anda masukkan tidak sesuai, silahkan periksa kembali data yang anda masukkan.');
                    return $this->render('ubah-profil', [
                        'model' => $model,
                        'model_perusahaan' => isset($model_perusahaan) ? $model_perusahaan : null,
                        'model_kecamatan' => isset($model_kecamatan) ? $model_kecamatan : null,
                        'model_lsm' => isset($model_lsm) ? $model_lsm : null,
                        'model_umkm' => isset($model_umkm) ? $model_umkm : null,
                        'model_upload_file1' => isset($model_upload_file1) ? $model_upload_file1 : null,
                        'model_upload_file2' => isset($model_upload_file2) ? $model_upload_file2 : null,
                        'model_upload_file3' => isset($model_upload_file3) ? $model_upload_file3 : null,
                        'model_sosmed' => isset($model_sosmed) ? $model_sosmed : null,
                        'model_sosmed_old' => isset($model_sosmed_old) ? $model_sosmed_old : null,
                        'file_logo' => isset($file_logo) ? $file_logo : null,
                        'file_npwp_perusahaan' => isset($file_npwp_perusahaan) ? $file_npwp_perusahaan : null,
                        'file_npwp_lsm' => isset($file_npwp_lsm) ? $file_npwp_lsm : null,
                        'file_npwp_umkm' => isset($file_npwp_umkm) ? $file_npwp_umkm : null,
                        'file_ktp' => isset($file_ktp) ? $file_ktp : null,
                    ]);
                } else {
                    if ($model->load(Yii::$app->request->post())) {
                        $model->perusahaan_id = $model_perusahaan->id;
                        $model->updated_at = time();
                        if (!($flag = $model->validate() && $model->save())) {
                            $transaction->rollBack();
                            Yii::$app->session->addFlash('danger', 'Data yang Anda masukkan tidak sesuai, silahkan periksa kembali data yang anda masukkan.') ;
                            return $this->render('ubah-profil', [
                                'model' => $model,
                                'model_perusahaan' => isset($model_perusahaan) ? $model_perusahaan : null,
                                'model_kecamatan' => isset($model_kecamatan) ? $model_kecamatan : null,
                                'model_lsm' => isset($model_lsm) ? $model_lsm : null,
                                'model_umkm' => isset($model_umkm) ? $model_umkm : null,
                                'model_upload_file1' => isset($model_upload_file1) ? $model_upload_file1 : null,
                                'model_upload_file2' => isset($model_upload_file2) ? $model_upload_file2 : null,
                                'model_upload_file3' => isset($model_upload_file3) ? $model_upload_file3 : null,
                                'model_sosmed' => isset($model_sosmed) ? $model_sosmed : null,
                                'model_sosmed_old' => isset($model_sosmed_old) ? $model_sosmed_old : null,
                                'file_logo' => isset($file_logo) ? $file_logo : null,
                                'file_npwp_perusahaan' => isset($file_npwp_perusahaan) ? $file_npwp_perusahaan : null,
                                'file_npwp_lsm' => isset($file_npwp_lsm) ? $file_npwp_lsm : null,
                                'file_npwp_umkm' => isset($file_npwp_umkm) ? $file_npwp_umkm : null,
                                'file_ktp' => isset($file_ktp) ? $file_ktp : null,
                            ]);
                        }
                    }
                    if ($model_upload_file1) {
                        if (!($flag = $this->uploadFilePerusahaan($model_upload_file1, ["perusahaan_id" => $model_perusahaan->id], ['logo' => 'logo', 'npwp_perusahaan' => 'npwp_perusahaan'], 'DataPerusahaanFile', 'storageCsr'))) {
                            $transaction->rollBack();
                            Yii::$app->session->addFlash('danger', 'Upload File gagal.') . '<pre>' . print_r($model_upload_file1->errors) . '</pre>';
                            return $this->render('ubah-profil', [
                                'model' => $model,
                                'model_perusahaan' => isset($model_perusahaan) ? $model_perusahaan : null,
                                'model_kecamatan' => isset($model_kecamatan) ? $model_kecamatan : null,
                                'model_lsm' => isset($model_lsm) ? $model_lsm : null,
                                'model_umkm' => isset($model_umkm) ? $model_umkm : null,
                                'model_upload_file1' => isset($model_upload_file1) ? $model_upload_file1 : null,
                                'model_upload_file2' => isset($model_upload_file2) ? $model_upload_file2 : null,
                                'model_upload_file3' => isset($model_upload_file3) ? $model_upload_file3 : null,
                                'model_sosmed' => isset($model_sosmed) ? $model_sosmed : null,
                                'model_sosmed_old' => isset($model_sosmed_old) ? $model_sosmed_old : null,
                                'file_logo' => isset($file_logo) ? $file_logo : null,
                                'file_npwp_perusahaan' => isset($file_npwp_perusahaan) ? $file_npwp_perusahaan : null,
                                'file_npwp_lsm' => isset($file_npwp_lsm) ? $file_npwp_lsm : null,
                                'file_npwp_umkm' => isset($file_npwp_umkm) ? $file_npwp_umkm : null,
                                'file_ktp' => isset($file_ktp) ? $file_ktp : null,
                            ]);
                        }
                    }
                    if ($model_sosmed) {
                        $model_sosmed_ = DataPerusahaanSosialMedia::find()->where(['perusahaan_id' => $model_perusahaan->id])->all();
                        if ($model_sosmed_) {
                            foreach ($model_sosmed_ as $model_sosmed_) {
                                $model_sosmed_->delete();
                            }
                        }
                        if (is_array($model_sosmed->jenis_sosial_media)) {
                            for ($i = 0; $i < count($model_sosmed->jenis_sosial_media); $i++) {
                                $model_sosial_media = new DataPerusahaanSosialMedia();
                                $model_sosial_media->perusahaan_id = $model->id;
                                $model_sosial_media->jenis_sosial_media = $model_sosmed->jenis_sosial_media[$i];
                                $model_sosial_media->url = $model_sosmed->url[$i];
                                $model_sosial_media->save();
                            }
                        }
                    }
                }

                if ($flag) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Data Berhasil Disimpan.");
                    return $this->redirect(['profil']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                return $this->render('ubah-profil', [
                    'model' => $model,
                    'model_perusahaan' => isset($model_perusahaan) ? $model_perusahaan : null,
                    'model_kecamatan' => isset($model_kecamatan) ? $model_kecamatan : null,
                    'model_lsm' => isset($model_lsm) ? $model_lsm : null,
                    'model_umkm' => isset($model_umkm) ? $model_umkm : null,
                    'model_upload_file1' => isset($model_upload_file1) ? $model_upload_file1 : null,
                    'model_upload_file2' => isset($model_upload_file2) ? $model_upload_file2 : null,
                    'model_upload_file3' => isset($model_upload_file3) ? $model_upload_file3 : null,
                    'model_sosmed' => isset($model_sosmed) ? $model_sosmed : null,
                    'model_sosmed_old' => isset($model_sosmed_old) ? $model_sosmed_old : null,
                    'file_logo' => isset($file_logo) ? $file_logo : null,
                    'file_npwp_perusahaan' => isset($file_npwp_perusahaan) ? $file_npwp_perusahaan : null,
                    'file_npwp_lsm' => isset($file_npwp_lsm) ? $file_npwp_lsm : null,
                    'file_npwp_umkm' => isset($file_npwp_umkm) ? $file_npwp_umkm : null,
                    'file_ktp' => isset($file_ktp) ? $file_ktp : null,
                ]);
            }
        } elseif (isset($model_umkm) && $model_umkm->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if (!($flag = $model_umkm->validate() && $model_umkm->save())) {
                    $transaction->rollBack();
                    Yii::$app->session->addFlash('danger', 'Data yang Anda masukkan tidak sesuai, silahkan periksa kembali data yang anda masukkan.') ;
                    return $this->render('ubah-profil', [
                        'model' => $model,
                        'model_perusahaan' => isset($model_perusahaan) ? $model_perusahaan : null,
                        'model_kecamatan' => isset($model_kecamatan) ? $model_kecamatan : null,
                        'model_lsm' => isset($model_lsm) ? $model_lsm : null,
                        'model_umkm' => isset($model_umkm) ? $model_umkm : null,
                        'model_upload_file1' => isset($model_upload_file1) ? $model_upload_file1 : null,
                        'model_upload_file2' => isset($model_upload_file2) ? $model_upload_file2 : null,
                        'model_upload_file3' => isset($model_upload_file3) ? $model_upload_file3 : null,
                        'model_sosmed' => isset($model_sosmed) ? $model_sosmed : null,
                        'model_sosmed_old' => isset($model_sosmed_old) ? $model_sosmed_old : null,
                        'file_logo' => isset($file_logo) ? $file_logo : null,
                        'file_npwp_perusahaan' => isset($file_npwp_perusahaan) ? $file_npwp_perusahaan : null,
                        'file_npwp_lsm' => isset($file_npwp_lsm) ? $file_npwp_lsm : null,
                        'file_npwp_umkm' => isset($file_npwp_umkm) ? $file_npwp_umkm : null,
                        'file_ktp' => isset($file_ktp) ? $file_ktp : null,
                    ]);
                } else {
                    if ($model->load(Yii::$app->request->post())) {
                        $model->masyarakat_id = $model_umkm->id;
                        $model->updated_at = time();
                        if (!($flag = $model->validate() && $model->save())) {
                            $transaction->rollBack();
                            Yii::$app->session->addFlash('danger', 'Data yang Anda masukkan tidak sesuai, silahkan periksa kembali data yang anda masukkan.') ;
                            return $this->render('ubah-profil', [
                                'model' => $model,
                                'model_perusahaan' => isset($model_perusahaan) ? $model_perusahaan : null,
                                'model_kecamatan' => isset($model_kecamatan) ? $model_kecamatan : null,
                                'model_lsm' => isset($model_lsm) ? $model_lsm : null,
                                'model_umkm' => isset($model_umkm) ? $model_umkm : null,
                                'model_upload_file1' => isset($model_upload_file1) ? $model_upload_file1 : null,
                                'model_upload_file2' => isset($model_upload_file2) ? $model_upload_file2 : null,
                                'model_upload_file3' => isset($model_upload_file3) ? $model_upload_file3 : null,
                                'model_sosmed' => isset($model_sosmed) ? $model_sosmed : null,
                                'model_sosmed_old' => isset($model_sosmed_old) ? $model_sosmed_old : null,
                                'file_logo' => isset($file_logo) ? $file_logo : null,
                                'file_npwp_perusahaan' => isset($file_npwp_perusahaan) ? $file_npwp_perusahaan : null,
                                'file_npwp_lsm' => isset($file_npwp_lsm) ? $file_npwp_lsm : null,
                                'file_npwp_umkm' => isset($file_npwp_umkm) ? $file_npwp_umkm : null,
                                'file_ktp' => isset($file_ktp) ? $file_ktp : null,
                            ]);
                        }
                    }
                    if ($model_upload_file3) {
                        if (!($flag = $this->uploadFileMasyarakat($model_upload_file3, ["masyarakat_id" => $model_umkm->id], ['ktp' => 'ktp', 'npwp' => 'npwp'], 'DataMasyarakatFile', 'storageCsr', 'data_umkm/'))) {
                            $transaction->rollBack();
                            Yii::$app->session->addFlash('danger', 'Data File yang Anda masukkan tidak sesuai, silahkan periksa kembali data yang anda masukkan.');
                            return $this->render('ubah-profil', [
                                'model' => $model,
                                'model_perusahaan' => isset($model_perusahaan) ? $model_perusahaan : null,
                                'model_kecamatan' => isset($model_kecamatan) ? $model_kecamatan : null,
                                'model_lsm' => isset($model_lsm) ? $model_lsm : null,
                                'model_umkm' => isset($model_umkm) ? $model_umkm : null,
                                'model_upload_file1' => isset($model_upload_file1) ? $model_upload_file1 : null,
                                'model_upload_file2' => isset($model_upload_file2) ? $model_upload_file2 : null,
                                'model_upload_file3' => isset($model_upload_file3) ? $model_upload_file3 : null,
                                'model_sosmed' => isset($model_sosmed) ? $model_sosmed : null,
                                'model_sosmed_old' => isset($model_sosmed_old) ? $model_sosmed_old : null,
                                'file_logo' => isset($file_logo) ? $file_logo : null,
                                'file_npwp_perusahaan' => isset($file_npwp_perusahaan) ? $file_npwp_perusahaan : null,
                                'file_npwp_lsm' => isset($file_npwp_lsm) ? $file_npwp_lsm : null,
                                'file_npwp_umkm' => isset($file_npwp_umkm) ? $file_npwp_umkm : null,
                                'file_ktp' => isset($file_ktp) ? $file_ktp : null,
                            ]);
                        }
                    }
                }

                if ($flag) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Data Berhasil Disimpan.");
                    return $this->redirect(['profil']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->addFlash('danger', 'Data yang Anda masukkan tidak sesuai, silahkan periksa kembali data yang anda masukkan.');
                return $this->render('ubah-profil', [
                    'model' => $model,
                    'model_perusahaan' => $model_perusahaan,
                    'model_kecamatan' => $model_kecamatan,
                    'model_lsm' => $model_lsm,
                    'model_umkm' => $model_umkm,
                    'model_upload_file1' => $model_upload_file1,
                    'model_upload_file2' => $model_upload_file2,
                    'model_upload_file3' => $model_upload_file3,
                    'model_sosmed' => $model_sosmed,
                    'model_sosmed_old' => $model_sosmed_old,
                    'file_logo' => $file_logo,
                    'file_npwp_perusahaan' => $file_npwp_perusahaan,
                    'file_npwp_lsm' => $file_npwp_lsm,
                    'file_npwp_umkm' => $file_npwp_umkm,
                    'file_ktp' => $file_ktp,
                ]);
            }
        } elseif (isset($model_lsm) && $model_lsm->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if (!($flag = $model_lsm->validate() && $model_lsm->save())) {
                    $transaction->rollBack();
                    Yii::$app->session->addFlash('danger', 'Data yang Anda masukkan tidak sesuai, silahkan periksa kembali data yang anda masukkan.') ;
                    return $this->render('ubah-profil', [
                        'model' => $model,
                        'model_perusahaan' => $model_perusahaan,
                        'model_kecamatan' => $model_kecamatan,
                        'model_lsm' => $model_lsm,
                        'model_umkm' => $model_umkm,
                        'model_upload_file1' => $model_upload_file1,
                        'model_upload_file2' => $model_upload_file2,
                        'model_upload_file3' => $model_upload_file3,
                        'model_sosmed' => $model_sosmed,
                        'model_sosmed_old' => $model_sosmed_old,
                        'file_logo' => $file_logo,
                        'file_npwp_perusahaan' => $file_npwp_perusahaan,
                        'file_npwp_lsm' => $file_npwp_lsm,
                        'file_npwp_umkm' => $file_npwp_umkm,
                        'file_ktp' => $file_ktp,
                    ]);
                } else {
                    if ($model->load(Yii::$app->request->post())) {
                        $model->lsm_id = $model_lsm->id;
                        $model->updated_at = time();
                        if (!($flag = $model->validate() && $model->save())) {
                            $transaction->rollBack();
                            Yii::$app->session->addFlash('danger', 'Data yang Anda masukkan tidak sesuai, silahkan periksa kembali data yang anda masukkan.');
                            return $this->render('ubah-profil', [
                                'model' => $model,
                                'model_perusahaan' => $model_perusahaan,
                                'model_kecamatan' => $model_kecamatan,
                                'model_lsm' => $model_lsm,
                                'model_umkm' => $model_umkm,
                                'model_upload_file1' => $model_upload_file1,
                                'model_upload_file2' => $model_upload_file2,
                                'model_upload_file3' => $model_upload_file3,
                                'model_sosmed' => $model_sosmed,
                                'model_sosmed_old' => $model_sosmed_old,
                                'file_logo' => $file_logo,
                                'file_npwp_perusahaan' => $file_npwp_perusahaan,
                                'file_npwp_lsm' => $file_npwp_lsm,
                                'file_npwp_umkm' => $file_npwp_umkm,
                                'file_ktp' => $file_ktp,
                            ]);
                        }
                    }
                    if ($model_upload_file2) {
                        if (!($flag = $this->uploadFileLsm($model_upload_file2, ["lsm_id" => $model_lsm->id], ['npwp' => 'npwp'], 'DataLsmFile', 'storageCsr', 'data_lsm/'))) {
                            Yii::$app->session->addFlash('danger', 'Data yang Anda masukkan tidak sesuai, silahkan periksa kembali data yang anda masukkan.');
                            $transaction->rollBack();
                            return $this->render('ubah-profil', [
                                'model' => $model,
                                'model_perusahaan' => $model_perusahaan,
                                'model_kecamatan' => $model_kecamatan,
                                'model_lsm' => $model_lsm,
                                'model_umkm' => $model_umkm,
                                'model_upload_file1' => $model_upload_file1,
                                'model_upload_file2' => $model_upload_file2,
                                'model_upload_file3' => $model_upload_file3,
                                'model_sosmed' => $model_sosmed,
                                'model_sosmed_old' => $model_sosmed_old,
                                'file_logo' => $file_logo,
                                'file_npwp_perusahaan' => $file_npwp_perusahaan,
                                'file_npwp_lsm' => $file_npwp_lsm,
                                'file_npwp_umkm' => $file_npwp_umkm,
                                'file_ktp' => $file_ktp,
                            ]);
                        }
                    }
                }

                if ($flag) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Data Berhasil Disimpan.");
                    return $this->redirect(['profil']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->addFlash('danger', 'Data yang Anda masukkan tidak sesuai, silahkan periksa kembali data yang anda masukkan.');
                return $this->render('ubah-profil', [
                    'model' => $model,
                    'model_perusahaan' => $model_perusahaan,
                    'model_kecamatan' => $model_kecamatan,
                    'model_lsm' => $model_lsm,
                    'model_umkm' => $model_umkm,
                    'model_upload_file1' => $model_upload_file1,
                    'model_upload_file2' => $model_upload_file2,
                    'model_upload_file3' => $model_upload_file3,
                    'model_sosmed' => $model_sosmed,
                    'model_sosmed_old' => $model_sosmed_old,
                    'file_logo' => $file_logo,
                    'file_npwp_perusahaan' => $file_npwp_perusahaan,
                    'file_npwp_lsm' => $file_npwp_lsm,
                    'file_npwp_umkm' => $file_npwp_umkm,
                    'file_ktp' => $file_ktp,
                ]);
            }
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

    public function actionGetKelurahanLsmJson()
    {
        $out = [];

        if (isset($_POST['depdrop_all_params'])) {
            $parents = $_POST['depdrop_all_params'];

            if ($parents != null) {
                $out = \app\models\WilayahKelurahan::find()
                    ->andWhere(['kecamatan_id' => $parents['kecamatan_lsm']])
                    ->select(["id AS id", "kelurahan AS name"])->asArray()->all();

                return Json::encode(['output' => $out, 'selected' => '']);
            } else {
                return Json::encode(['output' => '', 'selected' => '']);
            }
        }
    }

    public function actionGetKelurahanMasyarakatJson()
    {
        $out = [];

        if (isset($_POST['depdrop_all_params'])) {
            $parents = $_POST['depdrop_all_params'];

            if ($parents != null) {
                $out = \app\models\WilayahKelurahan::find()
                    ->andWhere(['kecamatan_id' => $parents['kecamatan_masyarakat']])
                    ->select(["id AS id", "kelurahan AS name"])->asArray()->all();

                return Json::encode(['output' => $out, 'selected' => '']);
            } else {
                return Json::encode(['output' => '', 'selected' => '']);
            }
        }
    }

    protected function uploadFilePerusahaan($model_upload_file1, array $field, array $keterangan, $model, $storage)
    {
        $file_mime_type = ['image/jpeg', 'image/png'];
        $file_extension = ['.jpeg', '.jpg', '.png'];

        if (!is_null($model_upload_file1)) {

            $perusahaan = UploadedFile::getInstance($model_upload_file1, 'perusahaanFile');
            $npwp = UploadedFile::getInstance($model_upload_file1, 'npwpFile');

            if (!empty($perusahaan)) {
                if ($perusahaan) {
                    $keterangan_perusahaan = $keterangan['logo'];

                    Yii::$app->saveFile->saveFile($perusahaan, $file_mime_type, $file_extension, $field, $keterangan_perusahaan, $model, $storage);
                }
            }

            if (!empty($npwp)) {
                if ($npwp) {
                    $keterangan_perusahaan = $keterangan['npwp_perusahaan'];

                    Yii::$app->saveFile->saveFile($npwp, $file_mime_type, $file_extension, $field, $keterangan_perusahaan, $model, $storage);
                }
            }

            return true;
        }
    }

    protected function uploadFileLsm($model_upload_file2, array $field, array $keterangan, $model, $storage, $path)
    {
        $file_mime_type = ['image/jpeg', 'image/png'];
        $file_extension = ['.jpeg', '.jpg', '.png'];

        if (!is_null($model_upload_file2)) {

            $npwp = UploadedFile::getInstance($model_upload_file2, 'npwpFile');

            if (!empty($npwp)) {
                if ($npwp) {
                    $keterangan_umkm = $keterangan['npwp'];

                    Yii::$app->saveFile->saveFile($npwp, $file_mime_type, $file_extension, $field, $keterangan_umkm, $model, $storage, $path);
                }
            }

            return true;
        }
    }

    protected function uploadFileMasyarakat($model_upload_file3, array $field, array $keterangan, $model, $storage, $path)
    {
        $file_mime_type = ['image/jpeg', 'image/png'];
        $file_extension = ['.jpeg', '.jpg', '.png', '.mp4',];

        if (!is_null($model_upload_file3)) {

            $ktp = UploadedFile::getInstance($model_upload_file3, 'ktpFile');
            $npwp = UploadedFile::getInstance($model_upload_file3, 'npwpFile');

            if (!empty($ktp)) {
                if ($ktp) {
                    $keterangan_umkm = $keterangan['ktp'];

                    Yii::$app->saveFile->saveFile($ktp, $file_mime_type, $file_extension, $field, $keterangan_umkm, $model, $storage, $path);
                }
            }

            if (!empty($npwp)) {
                if ($npwp) {
                    $keterangan_umkm = $keterangan['npwp'];

                    Yii::$app->saveFile->saveFile($npwp, $file_mime_type, $file_extension, $field, $keterangan_umkm, $model, $storage, $path);
                }
            }

            return true;
        }
    }
}
