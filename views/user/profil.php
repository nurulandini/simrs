<?php

use app\models\DataLsmFile;
use app\models\DataPerusahaanFile;
use yii\helpers\Html;

$this->title = 'Profil';

?>

<div class="card card-widget widget-user shadow-lg">
    <!-- <div class="widget-user-header text-white" style="background: url('../dist/img/photo1.png') center center;"> -->
    <?php if (Yii::$app->manage->roleCheck("admin_sistem")) { ?>
        <div class="widget-user-header text-white " style="background-color: #85A4B5;">

        </div>
        <div class="widget-user-image">
            <img class="img-circle" src="<?php echo yii\helpers\Url::to('@web/img/23.png'); ?>" alt="User Avatar" style="height: 95px; border:3px solid #fff; box-sizing: border-box;">
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header"><?= Html::encode($model->username);  ?></h3>
                            <span class="description-text">Super Admin</span>
                    </div>
                </div>
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header"><?= $model->email ?></h5>
                        <span class="description-text">Email</span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="description-block">
                        <h5 class="description-header"><?php
                                                        $status = $model->status;

                                                        if ($status == 10) {
                                                            echo "Aktif";
                                                        } else {
                                                            echo "Tidak Aktif";
                                                        }

                                                        ?></h5>
                        <span class="description-text">Status</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <!-- <div class="col-sm-6 border-right">
                    <div class="description-block">
                        <= Html::a('Ubah Profil', ['user/change-profil'], ['class' => 'btn btn-default outline btn-block btn-lg']) ?>
                    </div>
                </div> -->
                <!-- <div class="col-sm-4 border-right">
				<div class="description-block">
					<= Html::a('Ubah Foto', ['user/change-photo'], ['class' => 'btn btn-default outline btn-block btn-lg']) ?>
				</div>
			</div> -->
                <div class="col-sm-12">
                    <div class="description-block">
                        <?= Html::a('Ubah Password', ['user/change-password'], ['class' => 'btn btn-info outline btn-block btn-lg']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } else {
    ?>
        <div class="widget-user-header text-white " style="background-color: #85A4B5;">

        </div>
        <div class="widget-user-image">
            <img class="img-circle" src="<?php echo yii\helpers\Url::to('@web/img/23.png'); ?>" alt="User Avatar" style="height: 95px; border:3px solid #fff; box-sizing: border-box;">
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header"><?= Html::encode($model->email); ?></h5>
                        <span class="description-text">Email</span>
                    </div>
                </div>
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header"><?= Html::encode($model->pegawai->nama); ?></h3>
                            <span class="description-text"><?= Yii::$app->manage->roleCheck("dokter") ? "Dokter" : (Yii::$app->manage->roleCheck("administrasi") ? "Administrasi" : (Yii::$app->manage->roleCheck("farmasi") ? "Farmasi" : (Yii::$app->manage->roleCheck("kasir") ? "Kasir" : (Yii::$app->manage->roleCheck("manajemen") ? "Manajemen" : "Perawat")))) ?></span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="description-block">
                        <h5 class="description-header"><?php
                                                        $status = $model->status;

                                                        if ($status == 10) {
                                                            echo "Aktif";
                                                        } else {
                                                            echo "Tidak Aktif";
                                                        }

                                                        ?></h5>
                        <span class="description-text">Status</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6 border-right">
                    <div class="description-block">
                        <?= Html::a('Ubah Profil Akun', ['/user/ubah-profil'], ['class' => 'btn btn-info outline btn-block btn-lg', 'role' => 'modal-remote']) ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="description-block">
                        <?= Html::a('Ubah Password', ['/user/change-password'], ['class' => 'btn btn-warning outline btn-block btn-lg']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

</div>
<br>