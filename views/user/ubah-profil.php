<?php

use app\models\AuthItem as ModelsAuthItem;
use PhpOffice\PhpSpreadsheet\Calculation\Information\Value;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\models\User;
use yii\models\AuthItem;
use kartik\widgets\Select2;
use kartik\depdrop\DepDrop;
use yii\web\View;
use yii\helpers\Url;
use yii\widgets\MaskedInput;
use kartik\widgets\FileInput;
use kartik\number\NumberControl;
use app\models\WilayahKelurahan;
use app\models\WilayahKecamatan;
use yii\bootstrap4\Modal;
use yii\captcha\Captcha;
use kartik\widgets\DatePicker;

use function PHPSTORM_META\type;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$saveOptions = [
    'type' => 'text',
    'label' => '<label>Saved Value: </label>',
    'class' => 'kv-saved',
    'readonly' => true,
    'tabindex' => 1000
];

$saveCont = ['class' => 'kv-saved-cont'];

$this->registerJs("
$( document ).ready(function() {
    $('.register-box').delay(700).animate({ opacity: 1 }, 700);
});
");

$this->title = 'Ubah Profil';

?>


    <div id="" class="custom-form">
        <?php $form = \yii\bootstrap4\ActiveForm::begin() ?>

        <?= $form->field($model_perusahaan, 'npwp', [])->widget(MaskedInput::classname(), [
            'mask' => '9',
            'clientOptions' => ['repeat' => 15, 'greedy' => false],
            'options' => [
                'placeholder' => $model_perusahaan->getAttributeLabel('npwp'),
            ],
        ]) ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form->field($model, 'email')->textInput(['type' => 'email', 'placeholder' => $model->getAttributeLabel('email')]) ?>

        <?php if (!$model_perusahaan->isNewRecord) {
            $logo = [];
            $npwp_perusahaan = [];
            $json_logo = [];
            $json_npwp_perusahaan = [];

            if (isset($file_logo)) {
                if (!empty($file_logo)) {
                    foreach ($file_logo as $file_logo) {
                        $logo[] = (Yii::$app->storageCsr->has($file_logo->nama_file)) ? Yii::$app->storageCsr->getPresignedUrl($file_logo->nama_file, 104800) : $file_logo->nama_file_asli;
                        $json_logo[] = [
                            'filetype' => $file_logo->mime_type,
                            'type' => ($file_logo->mime_type == 'application/pdf') ? 'pdf' : (($file_logo->mime_type == 'video/mp4' || $file_logo->mime_type == 'video/3gpp') ? 'video' : 'image'),
                            'caption' => $file_logo->nama_file_asli,
                            'key' => $file_logo->id,
                        ];
                    }
                }
            }

            if (isset($file_npwp_perusahaan)) {
                if (!empty($file_npwp_perusahaan)) {
                    foreach ($file_npwp_perusahaan as $file_npwp_perusahaan) {
                        $npwp_perusahaan[] = (Yii::$app->storageCsr->has($file_npwp_perusahaan->nama_file)) ? Yii::$app->storageCsr->getPresignedUrl($file_npwp_perusahaan->nama_file, 104800) : $file_npwp_perusahaan->nama_file_asli;
                        $json_npwp_perusahaan[] = [
                            'filetype' => $file_npwp_perusahaan->mime_type,
                            'type' => ($file_npwp_perusahaan->mime_type == 'application/pdf') ? 'pdf' : (($file_npwp_perusahaan->mime_type == 'video/mp4' || $file_npwp_perusahaan->mime_type == 'video/3gpp') ? 'video' : 'image'),
                            'caption' => $file_npwp_perusahaan->nama_file_asli,
                            'key' => $file_npwp_perusahaan->id,
                        ];
                    }
                }
            }
        } ?>
        <?= $form->field($model_upload_file1, 'perusahaanFile')->widget(FileInput::className(), [
            'options' => [
                'multiple' => false,
                'accept' => 'image/png, image/jpeg, video/mp4, application/pdf',
            ],
            'pluginOptions' => [
                'deleteUrl' => '?r=data-perusahaan/hapus-berkas-ajax',
                'browseClass' => 'btn btn-outline-danger',
                'maxFileCount' => 10,
                'showRemove' => true,
                'showPreview' => true,
                'showCaption' => true,
                'showCancel' => false,
                'showUpload' => false,
                'initialPreview' => (!$model_perusahaan->isNewRecord) ? $logo : [],
                'initialPreviewAsData' => true,
                'initialPreviewConfig' => (!$model_perusahaan->isNewRecord) ? $json_logo : [],
                'overwriteInitial' => false,
                'dropZoneTitle' => 'Upload Logo <br>Jenis file yang bisa diupload : <br>*.png, *.jpg, *.jpeg, *.pdf atau *.mp4 <br><br>Ukuran maksimal/file 15MB'
            ]
        ]) ?>

        <?= $form->field($model_upload_file1, 'npwpFile')->widget(FileInput::className(), [
            'options' => [
                'multiple' => false,
                'accept' => 'image/png, image/jpeg, video/mp4, application/pdf'
            ],
            'pluginOptions' => [
                'deleteUrl' => '?r=data-perusahaan/hapus-berkas-ajax',
                'browseClass' => 'btn btn-outline-danger',
                'maxFileCount' => 10,
                'showRemove' => true,
                'showPreview' => true,
                'showCaption' => true,
                'showCancel' => false,
                'showUpload' => false,
                'initialPreview' => (!$model_perusahaan->isNewRecord) ? $npwp_perusahaan : [],
                'initialPreviewAsData' => true,
                'initialPreviewConfig' => (!$model_perusahaan->isNewRecord) ? $json_npwp_perusahaan : [],
                'overwriteInitial' => false,
                'dropZoneTitle' => 'Upload NPWP<br>Jenis file yang bisa diupload : <br>*.png, *.jpg, *.jpeg, *.pdf atau *.mp4 <br><br>Ukuran maksimal/file 15MB'
            ]
        ]) ?>

        <?= $form->field($model_perusahaan, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Nama Perusahaan']) ?>

        <?= $form->field($model_perusahaan, 'telepon')->widget(MaskedInput::classname(), [
            'mask' => '9',
            'clientOptions' => ['repeat' => 12, 'greedy' => false],
            'options' => [
                'placeholder' => 'Telepon Perusahaan',
            ],

        ]) ?>

        <?= $form->field($model_perusahaan, 'alamat')->textarea(['rows' => 6, 'placeholder' => 'Alamat Perusahaan']) ?>

        <?= $form->field($model_kecamatan, 'kecamatan_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\app\models\WilayahKecamatan::find()->where(['kabupaten_kota_id' => 26])->all(), 'id', 'kecamatan'),
            'options' => ['placeholder' => 'Pilih Kecamatan', 'id' => 'kecamatan_id', 'class' => 'form-control selects'],
        ]) ?>

        <div id="kelurahan_id_div">
            <?= $form->field($model_perusahaan, 'kelurahan_id')->widget(DepDrop::classname(), [
                'type' => DepDrop::TYPE_SELECT2,
                'options' =>
                [
                    'id' => 'kelurahan_id',
                ],
                'select2Options' =>
                [
                    'pluginOptions' =>
                    [
                        'dropdownParent' => '#kelurahan_id_div',
                    ]
                ],
                'pluginOptions' =>
                [
                    'depends' => ['kecamatan_id'],
                    'url' => Url::to(['get-kelurahan-json']),
                    'placeholder' => 'Pilih Kelurahan',
                    'initialize' => true,
                ]
            ]) ?>
        </div>
        <?= $form->field($model_perusahaan, 'negara_asal')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model_perusahaan, 'jenis_perusahaan')->dropDownList(['Swasta' => 'Swasta', 'BUMN' => 'BUMN', 'BUMD' => 'BUMD'], ['prompt' => 'Pilih Jenis Perusahaan']) ?>

        <?= $form->field($model_perusahaan, 'deskripsi')->textarea(['rows' => 6]) ?>

        <?= Html::button('Tambah Jenis Sosial Media', ['id' => 'tambah_sosmed', 'class' => 'btn btn-success']) ?>

        <div id="field_sosmed">

        </div>

        <div class="mt-3">
            <?= Html::submitButton('Simpan Data', ['class' => 'btn btn-primary btn-block text-uppercase', 'name' => 'button1']) ?>
        </div>
        <?php \yii\bootstrap4\ActiveForm::end(); ?>
        <br>
        <div class="col-12 mt-3 text-center text-muted text-sm">
            Bappeda Kota Medan &copy; <?= date('Y') ?>
        </div>
    </div>
<?php } elseif (Yii::$app->manage->roleCheck("Lsm")) { ?>
    <?= \hail812\adminlte\widgets\FlashAlert::widget() ?>
    <?php $form_lsm = ActiveForm::begin() ?>
    <?= $form_lsm->field($model_lsm, 'npwp', [])->widget(MaskedInput::classname(), [
        'mask' => '9',
        'clientOptions' => ['repeat' => 15, 'greedy' => false],
        'options' => [
            'placeholder' => $model_lsm->getAttributeLabel('npwp'),
        ],
    ]) ?>

    <?= $form_lsm->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('username')]) ?>

    <?= $form_lsm->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

    <?php if (!$model_lsm->isNewRecord) {
        $npwp = [];
        $json_npwp = [];

        if (isset($file_npwp_lsm)) {
            if (!empty($file_npwp_lsm)) {
                foreach ($file_npwp_lsm as $file_npwp_lsm) {
                    $npwp[] = (Yii::$app->storageCsr->has('data_lsm/' . $file_npwp_lsm->nama_file)) ? Yii::$app->storageCsr->getPresignedUrl('data_lsm/' . $file_npwp_lsm->nama_file, 104800) : $file_npwp_lsm->nama_file_asli;
                    $json_npwp[] = [
                        'filetype' => $file_npwp_lsm->mime_type,
                        'type' => ($file_npwp_lsm->mime_type == 'application/pdf') ? 'pdf' : (($file_npwp_lsm->mime_type == 'video/mp4' || $file_npwp_lsm->mime_type == 'video/3gpp') ? 'video' : 'image'),
                        'caption' => $file_npwp_lsm->nama_file_asli,
                        'key' => $file_npwp_lsm->id,
                    ];
                }
            }
        }
    } ?>

    <?= $form_lsm->field($model_upload_file2, 'npwpFile')->widget(FileInput::className(), [
        'options' => [
            'multiple' => false,
            'accept' => 'image/png, image/jpeg, video/mp4, application/pdf'
        ],
        'pluginOptions' => [
            'deleteUrl' => '?r=data-lsm/hapus-berkas-ajax',
            'browseClass' => 'btn btn-outline-danger',
            'maxFileCount' => 10,
            'showRemove' => true,
            'showCancel' => false,
            'showUpload' => false,
            'initialPreview' => (!$model_lsm->isNewRecord) ? $npwp : [],
            'initialPreviewAsData' => true,
            'initialPreviewConfig' => (!$model_lsm->isNewRecord) ? $json_npwp : [],
            'overwriteInitial' => false,
            'dropZoneTitle' => 'Upload NPWP <br>Jenis file yang bisa diupload : <br>*.png, *.jpg, *.jpeg, *.pdf atau *.mp4 <br><br>Ukuran maksimal/file 15MB'
        ]
    ]) ?>

    <?= $form_lsm->field($model_lsm, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form_lsm->field($model_lsm, 'alamat')->textarea(['rows' => 4]) ?>

    <?= $form_lsm->field($model_kecamatan, 'kecamatan_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\app\models\WilayahKecamatan::find()->where(['kabupaten_kota_id' => 26])->all(), 'id', 'kecamatan'),
        'options' => ['placeholder' => 'Pilih Kecamatan', 'id' => 'kecamatan_lsm', 'class' => 'form-control selects'],
    ]) ?>

    <div id="kelurahan_lsm_div">
        <?= $form_lsm->field($model_lsm, 'kelurahan_id')->widget(DepDrop::classname(), [
            'type' => DepDrop::TYPE_SELECT2,
            'options' =>
            [
                'id' => 'kelurahan_lsm',
            ],
            'select2Options' =>
            [
                'pluginOptions' =>
                [
                    'dropdownParent' => '#kelurahan_lsm_div',
                ]
            ],
            'pluginOptions' =>
            [
                'depends' => ['kecamatan_lsm'],
                'url' => Url::to(['get-kelurahan-lsm-json']),
                'placeholder' => 'Pilih Kelurahan',
                'initialize' => true,
            ]
        ]) ?>
        <div class="mt-3">
            <?= Html::submitButton('Simpan Perubahan', ['class' => 'btn btn-primary btn-block text-uppercase', 'name' => 'button2']) ?>
        </div>
        <?php ActiveForm::end(); ?>

        <br>
        <div class="col-12 mt-3 text-center text-muted text-sm">
            Bappeda Kota Medan &copy; <?= date('Y') ?>
        </div>
    <?php } elseif (Yii::$app->manage->roleCheck("Umkm")) { ?>

        <?= \hail812\adminlte\widgets\FlashAlert::widget() ?>
        <?php $form_umkm = ActiveForm::begin() ?>

        <?= $form_umkm->field($model_umkm, 'nik', [])->widget(MaskedInput::classname(), [
            'mask' => '9',
            'clientOptions' => ['repeat' => 16, 'greedy' => false],
            'options' => [
                'placeholder' => $model_umkm->getAttributeLabel('nik'),
            ],
        ]) ?>

        <?= $form_umkm->field($model_umkm, 'npwp', [])->widget(MaskedInput::classname(), [
            'mask' => '9',
            'clientOptions' => ['repeat' => 15, 'greedy' => false],
            'options' => [
                'placeholder' => $model_umkm->getAttributeLabel('npwp'),
            ],
        ]) ?>

        <?= $form_umkm->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form_umkm->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

        <?php
        if (!$model->isNewRecord) {
            $ktp = [];
            $npwp = [];
            $json_ktp = [];
            $json_npwp = [];

            if (isset($file_ktp)) {
                if (!empty($file_ktp)) {
                    foreach ($file_ktp as $file_ktp) {
                        $ktp[] = (Yii::$app->storageCsr->has('data_umkm/' . $file_ktp->nama_file)) ? Yii::$app->storageCsr->getPresignedUrl('data_umkm/' . $file_ktp->nama_file, 104800) : $file_ktp->nama_file_asli;
                        $json_ktp[] = [
                            'filetype' => $file_ktp->mime_type,
                            'type' => ($file_ktp->mime_type == 'application/pdf') ? 'pdf' : (($file_ktp->mime_type == 'video/mp4' || $file_ktp->mime_type == 'video/3gpp') ? 'video' : 'image'),
                            'caption' => $file_ktp->nama_file_asli,
                            'key' => $file_ktp->id,
                        ];
                    }
                }
            }

            if (isset($file_npwp_umkm)) {
                if (!empty($file_npwp_umkm)) {
                    foreach ($file_npwp_umkm as $file_npwp_umkm) {
                        $npwp[] = (Yii::$app->storageCsr->has('data_umkm/' . $file_npwp_umkm->nama_file)) ? Yii::$app->storageCsr->getPresignedUrl('data_umkm/' . $file_npwp_umkm->nama_file, 104800) : $file_npwp_umkm->nama_file_asli;
                        $json_npwp[] = [
                            'filetype' => $file_npwp_umkm->mime_type,
                            'type' => ($file_npwp_umkm->mime_type == 'application/pdf') ? 'pdf' : (($file_npwp_umkm->mime_type == 'video/mp4' || $file_npwp_umkm->mime_type == 'video/3gpp') ? 'video' : 'image'),
                            'caption' => $file_npwp_umkm->nama_file_asli,
                            'key' => $file_npwp_umkm->id,
                        ];
                    }
                }
            }
        }
        ?>

        <?= $form_umkm->field($model_upload_file3, 'ktpFile')->widget(FileInput::className(), [
            'options' => [
                'multiple' => false,
                'accept' => 'image/png, image/jpeg, video/mp4, application/pdf'
            ],
            'pluginOptions' => [
                'deleteUrl' => '?r=data-masyarakat/hapus-berkas-ajax',
                'browseClass' => 'btn btn-outline-danger',
                'maxFileCount' => 10,
                'showRemove' => true,
                'showCancel' => false,
                'showUpload' => false,
                'initialPreview' => (!$model_umkm->isNewRecord) ? $ktp : [],
                'initialPreviewAsData' => true,
                'initialPreviewConfig' => (!$model_umkm->isNewRecord) ? $json_ktp : [],
                'overwriteInitial' => false,
                'dropZoneTitle' => 'Upload KTP <br>Jenis file yang bisa diupload : <br>*.png, *.jpg, *.jpeg, *.pdf atau *.mp4 <br><br>Ukuran maksimal/file 15MB'
            ]
        ]) ?>

        <?= $form_umkm->field($model_upload_file3, 'npwpFile')->widget(FileInput::className(), [
            'options' => [
                'multiple' => false,
                'accept' => 'image/png, image/jpeg, video/mp4, application/pdf'
            ],
            'pluginOptions' => [
                'deleteUrl' => '?r=data-masyarakat/hapus-berkas-ajax',
                'browseClass' => 'btn btn-outline-danger',
                'maxFileCount' => 10,
                'showRemove' => true,
                'showCancel' => false,
                'showUpload' => false,
                'initialPreview' => (!$model_umkm->isNewRecord) ? $npwp : [],
                'initialPreviewAsData' => true,
                'initialPreviewConfig' => (!$model_umkm->isNewRecord) ? $json_npwp : [],
                'overwriteInitial' => false,
                'dropZoneTitle' => 'Upload NPWP <br>Jenis file yang bisa diupload : <br>*.png, *.jpg, *.jpeg, *.pdf atau *.mp4 <br><br>Ukuran maksimal/file 15MB'
            ]
        ]) ?>

        <?= $form_umkm->field($model_umkm, 'nama')->textInput(['maxlength' => true]) ?>


        <?= $form_umkm->field($model_umkm, 'jenis_kelamin')->dropDownList([1 => 'Laki - Laki', 0 => 'Perempuan'], ['prompt' => 'Pilih Jenis Kelamin']) ?>

        <?= $form_umkm->field($model_umkm, 'tempat_lahir')->textInput(['maxlength' => true]) ?>


        <?= $form_umkm->field($model_umkm, 'tanggal_lahir')->widget(DatePicker::className(), [
            'options' => ['placeholder' => 'Pilih Tanggal', 'id' => 'tanggal_realisasi'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true,
            ]
        ]) ?>

        <?= $form_umkm->field($model_umkm, 'nama_usaha')->textInput(['maxlength' => true]) ?>

        <?= $form_umkm->field($model_umkm, 'bentuk_usaha')->textarea(['rows' => 6]) ?>

        <?= $form_umkm->field($model_umkm, 'sektor_usaha')->textarea(['rows' => 6]) ?>

        <?= $form_umkm->field($model_umkm, 'deskripsi_usaha')->textarea(['rows' => 6]) ?>

        <?= $form_umkm->field($model_umkm, 'nomor_hp')->widget(MaskedInput::classname(), [
            'mask' => '9',
            'clientOptions' => ['repeat' => 12, 'greedy' => false],
        ])->label(true) ?>

        <?= $form_umkm->field($model_umkm, 'alamat')->textarea(['rows' => 6]) ?>

        <?= $form_umkm->field($model_kecamatan, 'kecamatan_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\app\models\WilayahKecamatan::find()->where(['kabupaten_kota_id' => 26])->all(), 'id', 'kecamatan'),
            'options' => ['placeholder' => 'Pilih Kecamatan', 'id' => 'kecamatan_masyarakat', 'class' => 'form-control selects'],
        ]) ?>

        <div id="kelurahan_masyarakat_div">
            <?= $form_umkm->field($model_umkm, 'kelurahan_id')->widget(DepDrop::classname(), [
                'type' => DepDrop::TYPE_SELECT2,
                'options' =>
                [
                    'id' => 'kelurahan_masyarakat',
                ],
                'select2Options' =>
                [
                    'pluginOptions' =>
                    [
                        'dropdownParent' => '#kelurahan_masyarakat_div',
                    ]
                ],
                'pluginOptions' =>
                [
                    'depends' => ['kecamatan_masyarakat'],
                    'url' => Url::to(['get-kelurahan-masyarakat-json']),
                    'placeholder' => 'Pilih Kelurahan',
                    'initialize' => true,
                ]
            ]) ?>
        </div>

        <div class="mt-3">
            <?= Html::submitButton('Simpan Perubahan', ['class' => 'btn btn-primary btn-block text-uppercase', 'name' => 'button3']) ?>
        </div>
        <?php \yii\bootstrap4\ActiveForm::end(); ?>
        <br>
        <div class="col-12 mt-3 text-center text-muted text-sm">
            Bappeda Kota Medan &copy; <?= date('Y') ?>
        </div>

    <?php } ?>