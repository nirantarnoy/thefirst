<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use toxor88\switchery\Switchery;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="x_title">
            <h3><i class="fa fa-hourglass"></i> <?=$this->title?> <small></small></h3>
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

            <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal form-label-left']]); ?>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">รหัสลูกค้า <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'code')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ชื่อ <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">นามสกุล <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">บัตรประชาชน <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'card_id')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">กลุ่มลูกค้า <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'customer_group_id')->widget(Select2::className(),[
                            'data'=>ArrayHelper::map(\backend\models\CustomerGroup::find()->all(),'id','name'),
                        'options' => ['placeholder'=>'เลือกกลุ่ม'],
                        'pluginOptions' => [
                                'allowClear'=>true,
                        ]
                    ])->label(false) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">รายละเอียด <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'description')->textarea(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">เบอร์โทร
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">สถานะ <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label(false) ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <input type="submit" value="Save" class="btn btn-success">
                </div>
            </div>

                    <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>