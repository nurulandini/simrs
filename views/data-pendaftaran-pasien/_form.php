<?php

use kartik\date\DatePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DataPendaftaranPasien $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="data-pendaftaran-pasien-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tanggal_kunjungan')->widget(DatePicker::className(), [
        'options' => ['placeholder' => 'Pilih Tanggal', 'id' => 'tanggal_kunjungan'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'pasien_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\app\models\DataPasien::find()->all(), 'id', 'nama'),
        'options' => ['placeholder' => 'Pilih Pasien', 'id' => 'pasien_id', 'class' => 'form-control selects'],
    ]) ?>

    <?= $form->field($model_poli, 'poli_id')->dropDownList(
        ArrayHelper::map(\app\models\DataPoli::find()->all(), 'id', 'poli'),
        [
            'prompt' => 'Pilih Poli',
            'id' => 'poli-id',
            'class' => 'form-control',
        ]
    ) ?>

    <?php

    use app\models\DataPegawai;
    use app\models\User;
    use app\models\AuthAssignment;
    use app\models\DataJadwalPegawai;

    // Ambil hanya pegawai yang memiliki role 'dokter'
    $dokterList = DataPegawai::find()
        ->joinWith(['users.authAssignments'])
        ->joinWith('dataJadwalPegawais')
        ->where(['auth_assignment.item_name' => 'dokter'])
        ->asArray()
        ->all();

    $pegawaiJson = json_encode(array_map(function ($dokter) {
        return [
            'id' => $dokter['id'],
            'nama' => $dokter['nama'],
            'poli_id' => $dokter['poli_id'],
            'hari_kerja' => array_map('intval', array_column($dokter['dataJadwalPegawais'], 'hari_kerja')),
        ];
    }, $dokterList));
    ?>

    <script>
        var dokterData = <?= $pegawaiJson ?>;
    </script>

    <?= $form->field($model, 'pegawai_id')->dropDownList(
        [],
        [
            'prompt' => 'Pilih Pegawai',
            'id' => 'pegawai-id',
            'class' => 'form-control',
        ]
    ) ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<<JS
function getDayFromDate(dateString) {
    var dateObj = new Date(dateString);
    var jsDay = dateObj.getDay(); // 0 = Minggu, 1 = Senin, ..., 6 = Sabtu
    return (jsDay === 0) ? 7 : jsDay; // Ubah 0 (Minggu) menjadi 7 agar sesuai DB
}

function updatePegawaiList() {
    var poliId = $("#poli-id").val();
    var tanggalKunjungan = $("#tanggal_kunjungan").val();
    
    if (!tanggalKunjungan || !poliId) {
        $("#pegawai-id").html('<option value="">Pilih Pegawai</option>');
        return;
    }

    var hariKerja = getDayFromDate(tanggalKunjungan); // Ambil hari kerja dari tanggal kunjungan
    var options = '<option value="">Pilih Pegawai</option>';

    dokterData.forEach(function(dokter) {
        if (dokter.poli_id == poliId && dokter.hari_kerja.includes(hariKerja)) {
            options += '<option value="' + dokter.id + '">' + dokter.nama + '</option>';
        }
    });

    $("#pegawai-id").html(options);
}

// Panggil saat Poli atau Tanggal Kunjungan berubah
$("#poli-id, #tanggal_kunjungan").on("change", function() {
    updatePegawaiList();
});
JS;
$this->registerJs($script);
?>