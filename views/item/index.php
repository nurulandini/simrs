<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use mdm\admin\components\RouteRule;
use mdm\admin\components\Configs;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = Yii::t('rbac-admin', $labels['Items']);

$rules = array_keys(Configs::authManager()->getRules());
$rules = array_combine($rules, $rules);
unset($rules[RouteRule::RULE_NAME]);
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
                'attribute' => 'ruleName',
                'label' => Yii::t('rbac-admin', 'Rule Name'),
                'filter' => $rules
            ],
            [
                'attribute' => 'description',
                'label' => Yii::t('rbac-admin', 'Description'),
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
                Html::a(Yii::t('rbac-admin', 'Create ' . $labels['Item']), ['create'], ['class' => 'btn btn-outline-primary']).
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
