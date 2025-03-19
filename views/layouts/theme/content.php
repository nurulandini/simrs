<?php
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header" <?= ((strpos(Yii::$app->controller->action->id, 'index') !== false) || (strpos(Yii::$app->controller->action->id, 'dashboard') !== false) ) ? 'style="padding-top: 0px; padding-bottom: 0px;"' : "" ?>>
        <div class="container-fluid">
            <div class="row mb-2">
                <?php if((strpos(Yii::$app->controller->action->id, 'index') !== false) || (strpos(Yii::$app->controller->action->id, 'dashboard') !== false) || (strpos(Yii::$app->controller->action->id, 'beranda') !== false) ) {} else { ?>
                <div class="col-sm-6">
                    <h4 class="text-dark">
                        <?php
                            if (!is_null($this->title)) {
                                echo \yii\helpers\Html::encode($this->title);
                            } else {
                                echo \yii\helpers\Inflector::camelize($this->context->id);
                            }
                        ?>
                    </h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <?php
                    echo Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'options' => [
                            'class' => 'float-sm-right'
                        ]
                    ]);
                    ?>
                </div><!-- /.col -->
                <?php } ?>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <?= \hail812\adminlte\widgets\FlashAlert::widget() ?>
        <?= $content ?><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>