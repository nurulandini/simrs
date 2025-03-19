<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Transaksi $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="transaksi-form container mt-4">
    <div class="card shadow-sm p-4">
        <h3 class="mb-4">Form Transaksi</h3>

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'rekam_medis_id')->dropDownList(
                    $rekamMedisDropdown,
                    ['prompt' => 'Pilih Pasien', 'id' => 'rekam-medis-select', 'class' => 'form-control']
                ) ?>
            </div>
        </div>

        <!-- Detail Rekam Medis -->
        <div id="rekam-medis-detail" class="mt-4 p-3 border rounded bg-light" style="display: none;">
            <h5>Detail Rekam Medis</h5>
            <hr>
            <p><strong>Hasil Diagnosa:</strong> <span id="diagnosa-text"></span></p>
            <h6>Layanan Medis:</h6>
            <ul id="layanan-list" class="list-group mb-2"></ul>
            <h6>Resep Obat:</h6>
            <ul id="resep-list" class="list-group"></ul>
        </div>

        <!-- Form Biaya -->
        <div class="row mt-3">
            <div class="col-md-4">
                <?= $form->field($model, 'biaya_layanan')->textInput(['readonly' => true, 'id' => 'biaya-layanan', 'class' => 'form-control']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'biaya_obat')->textInput(['readonly' => true, 'id' => 'biaya-obat', 'class' => 'form-control']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'total_harga')->textInput(['readonly' => true, 'id' => 'total-harga', 'class' => 'form-control']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'status_pembayaran')->dropDownList(
                    [1 => 'Lunas', 0 => 'Belum Lunas'],
                    ['prompt' => 'Pilih Status Pembayaran', 'class' => 'form-control']
                ) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'metode_pembayaran')->dropDownList(
                    ['1' => 'Tunai', '2' => 'Transfer', '3' => 'Asuransi'],
                    ['prompt' => 'Pilih Metode', 'class' => 'form-control']
                ) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'asuransi')->dropDownList(
                    ['1' => 'Biaya Mandiri', '2' => 'BPJS', '3' => 'Asuransi lainnya'],
                    ['prompt' => 'Pilih Asuransi', 'class' => 'form-control']
                ) ?>
            </div>
        </div>

        <div class="form-group text-center mt-4">
            <?= Html::submitButton('Simpan Transaksi', ['class' => 'btn btn-success btn-lg']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<!-- AJAX untuk mengambil data -->
<?php
$url = Url::to(['transaksi/get-rekam-medis-detail']);
$script = <<< JS
    $('#rekam-medis-select').change(function() {
        var rekamMedisId = $(this).val();

        if (rekamMedisId) {
            $.ajax({
                url: '$url',
                type: 'GET',
                data: { id: rekamMedisId },
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.error) {
                        alert('Error: ' + data.error);
                        $('#rekam-medis-detail').hide();
                        return;
                    }

                    $('#diagnosa-text').html(data.diagnosa || 'Tidak ada diagnosa');
                    
                    var layananHtml = '';
                    if (data.layanan.length > 0) {
                        data.layanan.forEach(function(item) {
                            layananHtml += '<li class="list-group-item">' + item.nama_layanan + ' - Rp ' + item.biaya + '</li>';
                        });
                    } else {
                        layananHtml = '<li class="list-group-item">Tidak ada layanan</li>';
                    }
                    $('#layanan-list').html(layananHtml);

                    var resepHtml = '';
                    if (data.resep.length > 0) {
                        data.resep.forEach(function(item) {
                            resepHtml += '<li class="list-group-item">' + item.nama_obat + ' - Rp ' + item.biaya + '</li>';
                        });
                    } else {
                        resepHtml = '<li class="list-group-item">Tidak ada resep</li>';
                    }
                    $('#resep-list').html(resepHtml);

                    $('#biaya-layanan').val(data.biaya_layanan);
                    $('#biaya-obat').val(data.biaya_obat);
                    $('#total-harga').val(data.total_harga);

                    $('#rekam-medis-detail').fadeIn();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Terjadi kesalahan. Cek console untuk detail.');
                }
            });
        } else {
            $('#rekam-medis-detail').fadeOut();
        }
    });
JS;
$this->registerJs($script);
?>
