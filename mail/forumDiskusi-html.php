<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */


?>
<div class="verify-email">

    <p>Haloo <?= Html::encode($model->nama) ?> !</p>

    <p>Kamu mendapatkan komentar baru dari pertanyaan kamu mengenai "<?= Html::encode($model->judul) ?>"</p>
    <p>Ayok lihat komentarnya di forum diskusi TJSL/CSR</p>
</div>