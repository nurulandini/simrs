<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\search\DataSkrinningSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Skrinning';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-skrinning-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Data Skrinning', ['create'], ['class' => 'btn btn-success', 'data-pjax' => 0]) ?>
    </p>

    <?php Pjax::begin(['id' => 'data-skrinning-pjax', 'timeout' => 5000]); ?>

    <?= GridView::widget([
        'id' => 'data-skrinning-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => require(__DIR__ . '/_columns.php'), // Panggil file _columns.php
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php
$this->registerJs('
    $(document).on("pjax:end", function() {
        $(".select2").select2(); // Pastikan Select2 tetap aktif
    });
');
?>