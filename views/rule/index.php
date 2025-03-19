<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = Yii::t('rbac-admin', 'Rules');
?>
<div class="role-index">

    <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => Yii::t('rbac-admin', 'Name'),
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'noWrap' => true,
                'template' => '{view} {update} {delete}',
                'viewOptions'=>['title'=>'View','data-toggle'=>'tooltip', 'class' => 'btn btn-sm btn-outline-success'],
                'updateOptions'=>['title'=>'Update', 'data-toggle'=>'tooltip', 'class' => 'btn btn-sm btn-outline-primary'],
                'deleteOptions'=>['title'=>'Delete', 'data-toggle'=>'tooltip', 'class' => 'btn btn-sm btn-outline-danger'], 
            ],
        ],
        'toolbar'=> [
            ['content'=>
                Html::a(Yii::t('rbac-admin', 'Create Rule'), ['create'], ['class' => 'btn btn-outline-primary']).
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
