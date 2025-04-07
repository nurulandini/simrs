<?php

use app\models\LayananMedis;
use kartik\editors\Summernote;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="rekam-medis-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="card shadow-sm p-4">
        <h4 class="mb-3 text-success">Data Pasien</h4>
        <div class="row">
            <div class="col-md-6">
                <?php if ($model->isNewRecord): ?>
                    <?= $form->field($model, 'skrinning_id')->dropDownList(
                        $skrinningDropdown,
                        ['prompt' => 'Pilih Pasien', 'class' => 'form-control', 'id' => 'skrinning-dropdown']
                    ) ?>
                <?php else: ?>
                    <div class="form-group">
                        <label for="skrinning_id">Nama Pasien</label>
                        <input type="text" class="form-control" value="<?= $model->skrinning->pendaftaran->pasien->nama ?>" readonly />
                    </div>
                    <?= $form->field($model, 'skrinning_id')->hiddenInput()->label(false) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (!$model->isNewRecord): ?>
        <div id="data-skrinning" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 8px;">
            <h4 class="mb-3 text-primary">📋 Data Skrinning</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="10%">Tinggi Badan</th>
                            <td width="2%">:</td>
                            <td><span id="tinggi"><?= $model->skrinning->tinggi ?></span> cm</td>
                        </tr>
                        <tr>
                            <th>Berat Badan</th>
                            <td>:</td>
                            <td><span id="berat"><?= $model->skrinning->berat ?></span> kg</td>
                        </tr>
                        <tr>
                            <th>Tekanan Darah</th>
                            <td>:</td>
                            <td><span id="tekanan_darah"><?= $model->skrinning->tekanan_darah ?></span></td>
                        </tr>
                        <tr>
                            <th>Suhu</th>
                            <td>:</td>
                            <td><span id="suhu"><?= $model->skrinning->suhu ?></span> °C</td>
                        </tr>
                        <tr>
                            <th>Denyut Jantung</th>
                            <td>:</td>
                            <td><span id="denyut_jantung"><?= $model->skrinning->denyut_jantung ?></span> bpm</td>
                        </tr>
                        <tr>
                            <th>Saturasi Oksigen</th>
                            <td>:</td>
                            <td><span id="saturasi_oksigen"><?= $model->skrinning->saturasi_oksigen ?></span>%</td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>:</td>
                            <td><span id="catatan"><?= $model->skrinning->catatan ?></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <!-- Menampilkan Data Skrining  -->
    <div id="data-skrinning" style="display:none; border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 8px;">
        <h4 class="mb-3 text-primary">📋 Data Skrinning</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width="10%">Tinggi Badan</th>
                        <td width="2%">:</td>
                        <td><span id="tinggi"></span> cm</td>
                    </tr>
                    <tr>
                        <th>Berat Badan</th>
                        <td>:</td>
                        <td><span id="berat"></span> kg</td>
                    </tr>
                    <tr>
                        <th>Tekanan Darah</th>
                        <td>:</td>
                        <td><span id="tekanan_darah"></span></td>
                    </tr>
                    <tr>
                        <th>Suhu</th>
                        <td>:</td>
                        <td><span id="suhu"></span> °C</td>
                    </tr>
                    <tr>
                        <th>Denyut Jantung</th>
                        <td>:</td>
                        <td><span id="denyut_jantung"></span> bpm</td>
                    </tr>
                    <tr>
                        <th>Saturasi Oksigen</th>
                        <td>:</td>
                        <td><span id="saturasi_oksigen"></span>%</td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>:</td>
                        <td><span id="catatan"></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow-sm p-4 mt-4">
        <h4 class="mb-3 text-success">Diagnosa</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="form-check-group">
                    <?= $form->field($model, 'diagnosa')->widget(Summernote::class, [
                        'useKrajeePresets' => true,
                        'container' => [
                            'class' => 'kv-editor-container',
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
                        // other widget settings
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Menampilkan Layanan Medis -->
    <?php if (!$model->isNewRecord): ?>
        <div id="layanan-medis" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 8px;">
            <h4 class="mb-3 text-primary">Layanan Medis</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Layanan</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model->rekamMedisDetails as $index => $layanan): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $layanan->layanan->layanan ?></td>
                                <td><?= number_format($layanan->biaya, 0, ',', '.') ?> IDR</td>
                                <td>
                                    <!-- Tombol untuk hapus layanan -->
                                    <?= Html::a('Hapus', ['delete-layanan', 'id' => $layanan->id], [
                                        'class' => 'btn btn-danger btn-sm',
                                        'data' => [
                                            'confirm' => 'Apakah Anda yakin ingin menghapus layanan ini?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Layanan Medis -->
            <div class="card shadow-sm p-4 mt-4">
                <h4 class="mb-3 text-success">Layanan Medis</h4>
                <div class="row">
                    <div class="col-md-12">
                        <?= Select2::widget([
                            'name' => 'layanan_medis[]',
                            'data' => ArrayHelper::map(LayananMedis::find()->all(), 'id', 'layanan'),
                            'options' => [
                                'placeholder' => 'Pilih layanan medis...',
                                'multiple' => true,
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'tags' => true,
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($model->isNewRecord): ?>
        <!-- Layanan Medis -->
        <div class="card shadow-sm p-4 mt-4">
            <h4 class="mb-3 text-success">Layanan Medis</h4>
            <div class="row">
                <div class="col-md-12">
                    <?= Select2::widget([
                        'name' => 'layanan_medis[]',
                        'data' => ArrayHelper::map(LayananMedis::find()->all(), 'id', 'layanan'),
                        'options' => [
                            'placeholder' => 'Pilih layanan medis...',
                            'multiple' => true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'tags' => true,
                        ],
                    ]); ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <!-- Menampilkan Resep Obat -->
    <?php if (!$model->isNewRecord): ?>
        <div id="resep-obat" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 8px;">
            <h4 class="mb-3 text-primary">Resep Obat</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Obat</th>
                            <th>Jumlah</th>
                            <th>Aturan Pakai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model->dataResepDetails as $index => $resep): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $resep->obat->nama ?></td>
                                <td><?= $resep->dosis ?></td>
                                <td><?= $resep->jumlah ?></td>
                                <td><?= $resep->instruksi ?></td>
                                <td>
                                    <!-- Tombol untuk menghapus resep obat -->
                                    <?= Html::a('Hapus', ['delete-resep', 'id' => $resep->id], [
                                        'class' => 'btn btn-danger btn-sm',
                                        'data' => [
                                            'confirm' => 'Apakah Anda yakin ingin menghapus resep obat ini?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <label for="obat">Pilih Obat</label>
                <select id="obat-select" class="form-control">
                    <option value="">-- Cari dan Pilih Obat --</option>
                    <?php foreach ($obatList as $id => $obat) : ?>
                        <option value="<?= $id ?>" data-harga="<?= $obat['harga'] ?>">
                            <?= $obat['nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Container untuk menampung obat yang dipilih -->
            <div id="obat-container"></div>
        </div>
    <?php endif; ?>

    <!-- Layanan Obat -->
    <?php if ($model->isNewRecord): ?>
    <div class="card shadow-sm p-4 mt-4">
        <h4 class="mb-3 text-success">Resep Obat</h4>
        <div class="row">
            <div class="col-md-12">
                <label for="obat">Pilih Obat</label>
                <select id="obat-select" class="form-control">
                    <option value="">-- Cari dan Pilih Obat --</option>
                    <?php foreach ($obatList as $id => $obat) : ?>
                        <option value="<?= $id ?>" data-harga="<?= $obat['harga'] ?>">
                            <?= $obat['nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <!-- Container untuk menampung obat yang dipilih -->
                <div id="obat-container" style="padding-top: 10px;"></div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm p-4 mt-4">
        <h4 class="mb-3 text-success">Catatan</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="form-check-group">
                    <?= $form->field($model, 'catatan')->widget(Summernote::class, [
                        'useKrajeePresets' => true,
                        'container' => [
                            'class' => 'kv-editor-container',
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
                        // other widget settings
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>


    <div class="text-end mt-4">
        <?= Html::submitButton('Simpan Rekam Medis', ['class' => 'btn btn-primary px-4 py-2']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


<?php
$js = <<<JS
    $('.form-check-input').on('change', function() {
        let row = $(this).closest('tr');
        let jumlahInput = row.find('.jumlah-obat');

        if ($(this).is(':checked')) {
            jumlahInput.prop('disabled', false).val(1);
        } else {
            jumlahInput.prop('disabled', true).val('');
        }
    });
JS;
$this->registerJs($js);
?>

<?php
$script = <<< JS
$(document).ready(function(){
    $("#skrinning-dropdown").change(function(){
        var skrinningId = $(this).val();
        if(skrinningId){
            $.ajax({
                url: "index.php?r=rekam-medis/get-skrinning",
                type: "GET",
                data: { skrinning_id: skrinningId },
                success: function(data) {
                    var obj = JSON.parse(data);
                    if (obj.pendaftaran_id !== undefined) {
                        $("#pendaftaran_id").text(obj.pendaftaran_id);
                        $("#tinggi").text(obj.tinggi);
                        $("#berat").text(obj.berat);
                        $("#tekanan_darah").text(obj.tekanan_darah);
                        $("#suhu").text(obj.suhu);
                        $("#denyut_jantung").text(obj.denyut_jantung);
                        $("#saturasi_oksigen").text(obj.saturasi_oksigen);
                        $("#catatan").html(obj.catatan);
                        $("#data-skrinning").show();
                    } else {
                        $("#data-skrinning").hide();
                    }
                }
            });
        } else {
            $("#data-skrinning").hide();
        }
    });
});
JS;
$this->registerJs($script);
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let obatSelect = document.getElementById("obat-select");
        let obatContainer = document.getElementById("obat-container");

        obatSelect.addEventListener("change", function() {
            let obatId = this.value;
            let obatNama = this.options[this.selectedIndex].text;
            let hargaPerUnit = this.options[this.selectedIndex].getAttribute("data-harga");

            if (obatId && !document.getElementById("obat-" + obatId)) {
                let obatHtml = `
                <div id="obat-${obatId}" class="form-group">
                    <label>${obatNama}</label>
                    <input type="hidden" name="obat_id[]" value="${obatId}">
                    <input type="number" name="jumlah[${obatId}]" min="1" class="form-control jumlah-obat" data-harga="${hargaPerUnit}" placeholder="Jumlah" required>
                    <input type="text" name="dosis[${obatId}]" class="form-control" placeholder="Dosis">
                    <input type="number" name="biaya[${obatId}]" class="form-control biaya-obat" placeholder="Biaya" readonly>
                    <textarea name="instruksi[${obatId}]" class="form-control" placeholder="Instruksi"></textarea>
                    <button type="button" class="btn btn-danger btn-sm remove-obat" data-id="${obatId}">Hapus</button>
                </div>
            `;

                obatContainer.insertAdjacentHTML("beforeend", obatHtml);

                // Event untuk tombol hapus
                document.querySelector(`#obat-${obatId} .remove-obat`).addEventListener("click", function() {
                    document.getElementById("obat-" + this.getAttribute("data-id")).remove();
                });

                // Event untuk menghitung biaya otomatis
                document.querySelector(`#obat-${obatId} .jumlah-obat`).addEventListener("input", function() {
                    let jumlah = this.value;
                    let harga = this.getAttribute("data-harga");
                    this.closest(".form-group").querySelector(".biaya-obat").value = jumlah * harga;
                });
            }
        });
    });
</script>