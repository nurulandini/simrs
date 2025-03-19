<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DataSatuan */
?>
<div class="data-satuan-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'satuan',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
