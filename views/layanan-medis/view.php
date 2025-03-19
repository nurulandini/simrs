<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LayananMedis */
?>
<div class="layanan-medis-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'layanan',
            'deskripsi:ntext',
            [
                'label' => 'Biaya Layanan',
                'attribute' => 'biaya',
                'value' => function ($model) {
                    return 'Rp. ' . number_format($model->biaya, 0, ",", ".");
                }
            ],
        ],
    ]) ?>

</div>