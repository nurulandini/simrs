<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\KategoriObat */
?>
<div class="kategori-obat-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kategori',
        ],
    ]) ?>

</div>