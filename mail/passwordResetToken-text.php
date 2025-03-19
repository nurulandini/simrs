<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
Halo <?= $user->username ?>, Anda menerima email ini karena Anda telah meminta request untuk me-reset password pada aplikasi <?= $app_name ?>. Jika Anda merasa tidak pernah membuat permintaan ini, silahkan abaikan email ini.

Silahkan kunjungi link dibawah ini untuk melihat instruksi ganti password :

<?= $resetLink ?>