<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DataPoli */
?>
<div class="data-poli-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'poli',
            'deskripsi:ntext'
        ],
    ]) ?>

</div>
