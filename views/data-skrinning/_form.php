<?php

use app\models\DataPegawai;
use app\models\DataPendaftaranPasien;
use app\models\User;
use kartik\editors\Summernote;
use kartik\number\NumberControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DataSkrinning $model */
/** @var yii\widgets\ActiveForm $form */

// $this->title = 'Tambah Data Skrinning';

$loggedInUserId = Yii::$app->user->identity->id;

if (Yii::$app->manage->roleCheck("dokter") || Yii::$app->manage->roleCheck("perawat")) {
    // Ambil ID Pegawai dari user yang login

    $data_pegawai = User::find()
        ->joinWith('pegawai')
        ->where(['user.id' => $loggedInUserId])
        ->one();

    if (!$data_pegawai || !$data_pegawai->pegawai) {
        throw new \yii\web\NotFoundHttpException("Pegawai tidak ditemukan.");
    }

    // Periksa apakah pegawai memiliki poli
    $poli_id = $data_pegawai->pegawai->poli_id ?? null;

    if (!$poli_id) {
        throw new \yii\web\NotFoundHttpException("Pegawai tidak memiliki Poli.");
    }

    // Debugging
    // dd($poli_id);

    // Ambil semua pendaftaran yang terkait dengan poli dari pegawai yang login

    $pendaftaranList = DataPendaftaranPasien::find()
        ->joinWith(['pegawai', 'pasien'])
        ->where(['data_pegawai.poli_id' => $poli_id])
        ->andWhere(['status' => 1])
        ->all();

    $pendaftaranData = ArrayHelper::map($pendaftaranList, 'id', function ($model) {
        return $model->pasien->nama ?? 'Pasien Tidak Diketahui';
    });
} elseif (Yii::$app->manage->roleCheck("admin_sistem")) {
    $pendaftaranList = DataPendaftaranPasien::find()
        ->where(['status' => 1])
        ->all();

    $pendaftaranData = ArrayHelper::map($pendaftaranList, 'id', function ($model) {
        return $model->pasien->nama ?? 'Pasien Tidak Diketahui';
    });
}



?>

<div class="data-skrinning-form">
    <div class="container">
        <?php $form = ActiveForm::begin(); ?>
        <!-- Dropdown untuk Pendaftaran -->

        <?php if ($model->isNewRecord): ?>
            <?= $form->field($model, 'pendaftaran_id')->dropDownList($pendaftaranData, [
                'prompt' => 'Pilih Pendaftaran...',
            ]) ?>
        <?php else: ?>
            <?= $form->field($model, 'pendaftaran_id')->textInput([
                'value' => $model->pendaftaran->pasien->nama, // Menampilkan nama pasien
                'disabled' => true
            ]) ?>
        <?php endif; ?>
        <?= $form->field($model, 'tinggi')->widget(NumberControl::classname(), [
            'maskedInputOptions' => [
                'suffix' => ' cm',
                'groupSeparator' => '.',
                'radixPoint' => ',',
                'allowMinus' => false,
                'digits' => 1000,
            ],
            'displayOptions' => ['class' => 'form-control kv-monospace'],
        ]) ?>
        <?= $form->field($model, 'berat')->widget(NumberControl::classname(), [
            'maskedInputOptions' => [
                'suffix' => ' kg',
                'groupSeparator' => '.',
                'radixPoint' => ',',
                'allowMinus' => false,
                'digits' => 1000,
            ],
            'displayOptions' => ['class' => 'form-control kv-monospace'],
        ]) ?>
        <?= $form->field($model, 'tekanan_darah')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'suhu')->widget(NumberControl::classname(), [
            'maskedInputOptions' => [
                'suffix' => ' °C',
                'groupSeparator' => '.',
                'radixPoint' => ',',
                'allowMinus' => false,
                'digits' => 1000,
            ],
            'displayOptions' => ['class' => 'form-control kv-monospace'],
        ]) ?>
        <?= $form->field($model, 'denyut_jantung')->widget(NumberControl::classname(), [
            'maskedInputOptions' => [
                'suffix' => ' bpm',
                'groupSeparator' => '.',
                'radixPoint' => ',',
                'allowMinus' => false,
                'digits' => 1000,
            ],
            'displayOptions' => ['class' => 'form-control kv-monospace'],
        ]) ?>
        <?= $form->field($model, 'saturasi_oksigen')->widget(NumberControl::classname(), [
            'maskedInputOptions' => [
                'suffix' => ' %',
                'groupSeparator' => '.',
                'radixPoint' => ',',
                'allowMinus' => false,
                'digits' => 1000,
            ],
            'displayOptions' => ['class' => 'form-control kv-monospace'],
        ]) ?>
        <!-- <= $form->field($model, 'catatan')->textarea(['rows' => 6]) ?> -->
        <?= $form->field($model, 'catatan', ['options' => ['class' => 'mb-2']])->widget(Summernote::class, [
            'useKrajeePresets' => true,
            'container' => [
                'style' => 'margin-bottom: 12%;padding :0; height:18%', // CSS inline
            ],
            'pluginOptions' => [
                'height' => 200,
                'toolbar' => [
                    ['style1', ['style']],
                    ['style2', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript']],
                    ['font', ['fontname', 'fontsize', 'color', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph', 'height']],
                    ['insert', ['link', 'picture', 'table', 'hr']],
                ],
            ]
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>