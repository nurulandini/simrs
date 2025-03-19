<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use kartik\grid\GridView;
use yii2ajaxcrud\ajaxcrud\CrudAsset;
use yii2ajaxcrud\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Verifikasi Akun';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="user-verifikasi-index">
    <div class="contact-info mt-4 px-3 rounded bg-white animate__animated animate__fadeInRight">
        <nav>
            <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-perusahaan-tab" data-toggle="tab" data-target="#nav-perusahaan" type="button" role="tab" aria-controls="nav-perusahaan" aria-selected="true">Perusahaan</button>
                <button class="nav-link" id="nav-lsm-tab" data-toggle="tab" data-target="#nav-lsm" type="button" role="tab" aria-controls="nav-lsm" aria-selected="false">LSM</button>
                <button class="nav-link" id="nav-umkm-tab" data-toggle="tab" data-target="#nav-umkm" type="button" role="tab" aria-controls="nav-umkm" aria-selected="false">UMKM</button>
                <button class="nav-link" id="nav-opd-tab" data-toggle="tab" data-target="#nav-opd" type="button" role="tab" aria-controls="nav-opd" aria-selected="false">OPD</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="margin-bottom: 25px;">
            <div class="tab-pane fade show active" id="nav-perusahaan" role="tabpanel" aria-labelledby="nav-perusahaan-tab">
                <div class="contact-info p-4 rounded bg-white animate__animated animate__fadeInRight">
                    <div class="text-center">
                        <p class="text-muted f-18">Verifikasi Akun Perusahaan</p>
                    </div>
                </div>
                <div id="ajaxCrudDatatable">
                    <?= GridView::widget([
                        'id' => 'crud-datatable',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'pjax' => true,
                        'columns' => require(__DIR__ . '/_columns.php'),
                        'toolbar' => [
                            [
                                'content' =>
                                Html::a(
                                    '<i class="fa fa-redo"></i>',
                                    [''],
                                    ['data-pjax' => 1, 'class' => 'btn btn-outline-success', 'title' => Yii::t('yii2-ajaxcrud', 'Reset Grid')]
                                ) .
                                    '{toggleData}'
                            ],
                        ],
                        'striped' => true,
                        'condensed' => true,
                        'responsive' => true,
                        'panel' => [
                            'type' => 'default',
                            'heading' => '<i class="fa fa-list"></i> <b>' . $this->title . '</b>'
                        ]
                    ]) ?>
                </div>
            </div>
            <div class="tab-pane fade " id="nav-lsm" role="tabpanel" aria-labelledby="nav-lsm-tab">
                <div class="contact-info p-4 rounded bg-white animate__animated animate__fadeInRight">
                    <div class="text-center">
                        <p class="text-muted f-18">Verifikasi Akun LSM</p>
                    </div>
                </div>
                <div id="ajaxCrudDatatable">
                    <?= GridView::widget([
                        'id' => 'crud-datatablelsm',
                        'dataProvider' => $dataProvider1,
                        'filterModel' => $searchModel,
                        'pjax' => true,
                        'columns' => require(__DIR__ . '/_columnslsm.php'),
                        'toolbar' => [
                            [
                                'content' =>
                                Html::a(
                                    '<i class="fa fa-redo"></i>',
                                    [''],
                                    ['data-pjax' => 1, 'class' => 'btn btn-outline-success', 'title' => Yii::t('yii2-ajaxcrud', 'Reset Grid')]
                                ) .
                                    '{toggleData}'
                            ],
                        ],
                        'striped' => true,
                        'condensed' => true,
                        'responsive' => true,
                        'panel' => [
                            'type' => 'default',
                            'heading' => '<i class="fa fa-list"></i> <b>' . $this->title . '</b>'
                        ]
                    ]) ?>
                </div>
            </div>
            <div class="tab-pane fade " id="nav-umkm" role="tabpanel" aria-labelledby="nav-umkm-tab">
                <div class="contact-info p-4 rounded bg-white animate__animated animate__fadeInRight">
                    <div class="text-center">
                        <p class="text-muted f-18">Verifikasi Akun UMKM</p>
                    </div>
                </div>
                <div id="ajaxCrudDatatable">
                    <?= GridView::widget([
                        'id' => 'crud-datatableumkm',
                        'dataProvider' => $dataProvider2,
                        'filterModel' => $searchModel,
                        'pjax' => true,
                        'columns' => require(__DIR__ . '/_columnsumkm.php'),
                        'toolbar' => [
                            [
                                'content' =>
                                Html::a(
                                    '<i class="fa fa-redo"></i>',
                                    [''],
                                    ['data-pjax' => 1, 'class' => 'btn btn-outline-success', 'title' => Yii::t('yii2-ajaxcrud', 'Reset Grid')]
                                ) .
                                    '{toggleData}'
                            ],
                        ],
                        'striped' => true,
                        'condensed' => true,
                        'responsive' => true,
                        'panel' => [
                            'type' => 'default',
                            'heading' => '<i class="fa fa-list"></i> <b>' . $this->title . '</b>'
                        ]
                    ]) ?>
                </div>
            </div>
            <div class="tab-pane fade " id="nav-opd" role="tabpanel" aria-labelledby="nav-opd-tab">
                <div class="contact-info p-4 rounded bg-white animate__animated animate__fadeInRight">
                    <div class="text-center">
                        <p class="text-muted f-18">Verifikasi Akun OPD</p>
                    </div>
                </div>
                <div id="ajaxCrudDatatable">
                    <?= GridView::widget([
                        'id' => 'crud-datatableopd',
                        'dataProvider' => $dataProvider3,
                        'filterModel' => $searchModel,
                        'pjax' => true,
                        'columns' => require(__DIR__ . '/_columnsopd.php'),
                        'toolbar' => [
                            [
                                'content' =>
                                Html::a(
                                    '<i class="fa fa-redo"></i>',
                                    [''],
                                    ['data-pjax' => 1, 'class' => 'btn btn-outline-success', 'title' => Yii::t('yii2-ajaxcrud', 'Reset Grid')]
                                ) .
                                    '{toggleData}'
                            ],
                        ],
                        'striped' => true,
                        'condensed' => true,
                        'responsive' => true,
                        'panel' => [
                            'type' => 'default',
                            'heading' => '<i class="fa fa-list"></i> <b>' . $this->title . '</b>'
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "", // always need it for jquery plugin
    "clientOptions" => [
        "tabindex" => false,
        "backdrop" => "static",
        "keyboard" => false,
    ],
    "options" => [
        "tabindex" => false
    ]
]) ?>
<?php Modal::end(); ?>