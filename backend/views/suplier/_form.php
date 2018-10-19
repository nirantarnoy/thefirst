<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use toxor88\switchery\Switchery;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\Province;
use common\models\Amphur;
use common\models\District;
use yii\helpers\Url;


$prov = Province::find()->all();
$amp = Amphur::find()->all();
$dist = District::find()->all();
/* @var $this yii\web\View */
/* @var $model backend\models\Vendor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-headline">
    <div class="panel-heading">
                    <h3><i class="fa fa-user"></i> <?=$this->title?> <small></small></h3>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">รหัสผู้ขาย <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'vendor_code')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ชื่อ <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">รายละเอียด 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'description')->textarea(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">เบอร์โทร
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?= $form->field($model, 'tel')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                          </div>
                      </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">กลุ่มผู้ขาย 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'vendor_group_id')->widget(Select2::className(),[
                                      'data' => ArrayHelper::map(backend\models\Supliergroup::find()->all(),'id','name'),
                                      'options' => ['placeholder'=>'เลือกกลุ่มผู้ขาย']
                                   ])->label(false) ?>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">สถานะ 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php echo $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label(false) ?>
                                </div>
                              </div>
                          

                             <div class="ln_solid"></div>


                      <hr>

                      <div class="col-md-8 col-md-offset-4">
                          <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
                          <?php if(!$model->isNewRecord):?>
                              <div class="btn btn-default"><a href="<?=Url::to(['vendor/view/','id'=>$model->id],true)?>">ดูรายละเอียด</a></div>
                          <?php endif;?>
                          <div class="btn btn-danger"><a style="color: #FFF" href="<?=Url::to(['vendor/index'],true)?>">ยกเลิก</a></div>
                      </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>

