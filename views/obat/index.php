<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\DataObatSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Obat';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-obat-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tambah Obat Baru', ['create'], [
            'class' => 'btn btn-success',
            'role' => 'modal-remote', // Jika pakai modal AJAX
        ]) ?>
    </p>

    <?php Pjax::begin(['id' => 'data-obat-pjax']); ?>
    
    <?= GridView::widget([
        'id' => 'data-obat-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => require(__DIR__ . '/_columns.php'),
        'toolbar' => [
            '{toggleData}',
            '{export}',
        ],
        'panel' => [
            'type' => 'default',
            'heading' => '<i class="fa fa-list"></i> Data Obats',
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php
// Pastikan Select2 tetap aktif setelah Pjax/AJAX reload
$this->registerJs('
    $(document).on("pjax:end", function() {
        $("#satuan_id").select2();
    });
');
?>