<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
?>
<div class="user-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
            [
                'label' => 'Role user',
                'format' => 'raw',
                'value' => function ($model) {
                    $role = \Yii::$app->authManager->getRolesByUser($model->id);
                    $rolefinal = "";
                    foreach ($role as $roles) {
                        if ($roles->name != 'guest') {
                            $rolefinal = $rolefinal . '' . $roles->name . '<br>';
                        }
                    }
                    return $rolefinal;
                }
            ]
        ],
    ]) ?>

</div>