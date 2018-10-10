<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Claim */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="x_title">
            <h3><i class="fa fa-bolt"></i> <?=$this->title?> <small></small></h3>
            <!-- <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Settings 1</a>
                  </li>
                  <li><a href="#">Settings 2</a>
                  </li>
                </ul>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul> -->
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <br />
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-lg-4">
                            <?= $form->field($model, 'claim_no')->textInput(['maxlength' => true,'value'=>$model->isNewRecord?$runno:$model->claim_no,'readonly'=>'readonly']) ?>

                        </div>
                        <div class="col-lg-4">
                            <?php $model->trans_date = $model->isNewRecord?date('d-m-Y'):date('d-m-Y',$model->trans_date) ?>
                            <?= $form->field($model, 'trans_date')->widget(DatePicker::className(),[
                                    'options'=>[
                                            'format'=>'dd-mm-yyyy',
                                        ]
                            ]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'sale_no')->textInput() ?>
                        </div>

                    </div>
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'status')->textInput() ?>
                </div>
            </div>

            <div class="form-group">

                    <input type="submit" value="Save" class="btn btn-success">

            </div>

                    <?php ActiveForm::end(); ?>

</div>
    </div>
</div>
