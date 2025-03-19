<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = Yii::t('rbac-admin', 'Menus');
?>
<div class="menu-index">

    <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'menuParent.name',
                'filter' => Html::activeTextInput($searchModel, 'parent_name', [
                    'class' => 'form-control', 'id' => null
                ]),
                'label' => Yii::t('rbac-admin', 'Parent'),
            ],
            'route',
            'order',
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
                Html::a(Yii::t('rbac-admin', 'Create Menu'), ['create'], ['class' => 'btn btn-outline-primary']).
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
