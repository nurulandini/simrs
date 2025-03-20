<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;

use yii2ajaxcrud\ajaxcrud\CrudAsset;
use yii\bootstrap4\ActiveForm;

$this->registerJs("
$( document ).ready(function() {
    $('.login-box').delay(700).animate({ opacity: 1 }, 700);
});
");
$this->registerCssFile('@web/css/custom.css', [
    'depends' => 'yii\bootstrap4\BootstrapAsset'
]);

$this->registerJs("
$( document ).ready(function() {
    $('.register-box').delay(500).animate({ opacity: 2 }, 700);
});
");
$this->title = 'Login';

CrudAsset::register($this);
?>
<style>
    .register-box {
        opacity: 0;

    }
</style>

<div class="container login">
    <div class="row">
        <div class="col-md-6">
            <div class="log-in">
                <img class="img-about" src="<?= yii\helpers\Url::to('@web/img/bg.png') ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <h2 style="padding-left:30%;"><b>Selamat Datang di</b></h2>
            </div>
            <div class="row">
                <h2 class="text-center" style="padding-left:15%"><b>Sistem Informasi Manajemen Klinik</b></h2>
            </div>
            <div class="login-box">
                <div class="card ">
                    <div class="card-header text-center ">
                        <h1 >Masuk</h1>
                    </div>
                    <div class="card-body">
                        <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>
                        <?= $form->field($model, 'username', ['options' => ['class' => 'user-box has-feedback']])
                            ->label(false)
                            ->textInput(
                                ['placeholder' => $model->getAttributeLabel('username')],
                                ['options' => ['class' => 'user-box has-feedback']]
                            )
                        ?>
                        <?= $form->field($model, 'password', ['options' => ['class' => 'user-box has-feedback'],])
                            ->label(false)
                            ->passwordInput(
                                ['placeholder' => $model->getAttributeLabel('password')],
                                ['options' => ['class' => 'user-box has-feedback']]
                            )
                        ?>
                        <!-- <= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        ]) ?> -->
                        <!-- <div class="col-4"> -->
                        <?= Html::submitButton('Login', ['class' => 'submit btn button-form']) ?>
                        <!-- </div> -->
                        <?php ActiveForm::end(); ?>
                    </div>

                    <div class="mb-2 text-center">
                        <?= Html::a('<span class="fa fa-lock"></span> Lupa password? Klik disini.', ['site/request-password-reset'], ['class' => 'text-dark font']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "size" => "modal-md",
    "footer" => "", // always need it for jquery plugin
    "options" => [
        "tabindex" => false,
        "style" => "margin-top : 100px"
    ],
    "clientOptions" => [
        "tabindex" => false,
        "backdrop" => false,
        "keyboard" => false,
    ],
]) ?>
<?php Modal::end(); ?>