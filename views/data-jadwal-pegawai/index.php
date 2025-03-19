<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use kartik\grid\GridView;
use yii2ajaxcrud\ajaxcrud\CrudAsset;
use yii2ajaxcrud\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\DataJadwalPegawaiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Jadwal Pegawai';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
use yii\data\ArrayDataProvider;

$hariList = [
    1 => "Senin",
    2 => "Selasa",
    3 => "Rabu",
    4 => "Kamis",
    5 => "Jumat",
    6 => "Sabtu",
    7 => "Minggu",
];

// Konversi $groupedJadwal ke DataProvider agar bisa dipake di GridView
$dataProvider = new ArrayDataProvider([
    'allModels' => $groupedJadwal,
    'pagination' => false,
]);
?>

<div class="data-jadwal-pegawai-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar' => [
                ['content'=>
                    Html::a(Yii::t('yii2-ajaxcrud', 'Create New'), ['create'],
                    ['role' => 'modal-remote', 'title' => Yii::t('yii2-ajaxcrud', 'Create New').' Data Jadwal Pegawais', 'class' => 'btn btn-outline-primary']).
                    Html::a('<i class="fa fa-redo"></i>', [''],
                    ['data-pjax' => 1, 'class' => 'btn btn-outline-success', 'title' => Yii::t('yii2-ajaxcrud', 'Reset Grid')]).
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'default', 
                'heading' => '<i class="fa fa-list"></i> <b>'.$this->title.'</b>',
                'before' =>'<em>* '.Yii::t('yii2-ajaxcrud', 'Resize Column').'</em>',
                'after' => BulkButtonWidget::widget([
                    'buttons' => Html::a('<i class="fa fa-trash"></i>&nbsp; '.Yii::t('yii2-ajaxcrud', 'Delete All'),
                        ["bulkdelete"] ,
                        [
                            'class' => 'btn btn-danger btn-xs',
                            'role' => 'modal-remote-bulk',
                            'data-confirm' => false,
                            'data-method' => false,
                            'data-request-method' => 'post',
                            'data-confirm-title' => Yii::t('yii2-ajaxcrud', 'Delete'),
                            'data-confirm-message' => Yii::t('yii2-ajaxcrud', 'Delete Confirm')
                        ]),
                ]).                        
                '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "", 
    "clientOptions" => [
        "tabindex" => false,
        "backdrop" => "static",
        "keyboard" => false,
    ],
    "options" => [
        "tabindex" => false
    ]
])?>
<?php Modal::end(); ?>