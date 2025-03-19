
<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Halo <?= Html::encode($user->username) ?>, Anda menerima email ini karena Anda telah meminta request untuk me-reset password pada aplikasi <?= Html::encode($app_name) ?>. Jika Anda merasa tidak pernah membuat permintaan ini, silahkan abaikan email ini.</p>

    <p>Silahkan kunjungi link dibawah ini untuk melihat instruksi ganti password :</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
