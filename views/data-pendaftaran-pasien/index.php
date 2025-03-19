<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\DataPendaftaranPasienSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Pendaftaran Pasien';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-pendaftaran-pasien-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Data Pendaftaran Pasien', ['create'], [
            'class' => 'btn btn-success',
            'role' => 'modal-remote', // Jika pakai modal AJAX
        ]) ?>
    </p>

    <?php Pjax::begin(['id' => 'data-pendaftaran-pasien-pjax', 'timeout' => 5000]); ?>

    <?= GridView::widget([
        'id' => 'data-pendaftaran-pasien-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => require(__DIR__ . '/_columns.php'),
        'pjax' => true,
        'toolbar' => [
            '{toggleData}',
            '{export}',
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php
$this->registerJs('
    // Pastikan data direfresh otomatis setelah Pjax selesai dimuat
    $(document).on("pjax:end", function() {
        $.pjax.reload({container: "#data-pendaftaran-pasien-pjax", async: false});
    });
');
?>
