<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = Yii::t('rbac-admin', 'Assignments');

$columns = [
    ['class' => 'kartik\grid\SerialColumn'],
    $usernameField,
];
if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}
$columns[] = [
    'class' => 'kartik\grid\ActionColumn',
    'noWrap' => true,
    'template' => '{view}',
    'viewOptions'=>['title'=>'View', 'data-toggle'=>'tooltip', 'class' => 'btn btn-sm btn-outline-success'],
];
?>
<div class="assignment-index">

    <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'columns' => $columns,
        'toolbar'=> [
            ['content'=>
                Html::a('<i class="fa fa-redo"></i>', [''],
                ['data-pjax'=>1, 'class'=>'btn btn-outline-success', 'title'=>'Reset Grid']).
                '{toggleData}'
            ],
        ],          
        'striped' => true,
        'condensed' => true,
        'responsive' => true,          
        'panel' => [
            'type' => 'default', 
            'heading' => '<i class="fa fa-list"></i> <b>'.$this->title.'</b>',
        ]
    ])?>

</div>
