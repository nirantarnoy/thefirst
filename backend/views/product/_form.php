<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use toxor88\switchery\Switchery;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */

$vendorlist = \backend\models\Suplier::find()->where(['status'=>1])->all();
?>

<div class="product-form">
<?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal form-label-left','enctype'=>'multipart/form-data']]); ?>
    <div class="panel panel-headline">
        <div class="panel-heading">
                    <h3><i class="fa fa-cube"></i> <?=$this->title?> <small></small></h3>

                    <div class="clearfix"></div>
                  </div>
                  <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">รหัสสินค้า <span class="required">*</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                               <?= $form->field($model, 'product_code')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ชื่อสินค้า <span class="required"></span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                               <?= $form->field($model, 'name')->textarea(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                            </div>
                                          </div>
                                           <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">รายละเอียด <span class="required"></span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                               <?= $form->field($model, 'description')->textarea(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                            </div>
                                          </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ต้นทุน <span class="required"></span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?= $form->field($model, 'cost')->textInput(['maxlength' => true,'class'=>'form-control','value'=>$model->cost!=""?$model->cost:0])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">สถานะ <span class="required"></span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?= $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">จำนวนสินค้า <span class="required"></span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?= $form->field($model, 'all_qty')->textInput(['maxlength' => true,'class'=>'form-control','disabled'=>'disabled','value'=>$model->all_qty!=""?$model->all_qty:0])->label(false) ?>
                                        </div>
                                    </div>


                                </div>
                                 <div class="col-lg-6">
                                     <div class="form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">หมวดสินค้า <span class="required"></span>
                                         </label>
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?= $form->field($model, 'category_id')->widget(Select2::className(),[
                                                 'data' => ArrayHelper::map(backend\models\Productcat::find()->all(),'id','name'),
                                                 'options' => ['placeholder'=>'เลือกกลุ่มสินค้า']
                                             ])->label(false) ?>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">บาร์โค้ด <span class="required"></span>
                                         </label>
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?= $form->field($model, 'barcode')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">หน่วยนับ <span class="required"></span>
                                         </label>
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?= $form->field($model, 'unit_id')->widget(Select2::className(),[
                                                 'data' => ArrayHelper::map(backend\models\Unit::find()->all(),'id','name'),
                                                 'options' => ['placeholder'=>'เลือกหน่วยนับ']
                                             ])->label(false) ?>
                                         </div>
                                     </div>



                                           <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ราคา <span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                               <?= $form->field($model, 'price')->textInput(['maxlength' => true,'class'=>'form-control','value'=>$model->price!=""?$model->price:0])->label(false) ?>
                                            </div>
                                          </div>

                                           
                                 </div>
                                
                            </div>

                           <hr />
                            <p><h3>รูปภาพ</h3></p>
                      <div class="row">
                          <div class="col-lg-12">
                              <?php if(!$model->isNewRecord): ?>
                                  <div class="panel panel-body">  <div class="row">
                                          <?php foreach ($modelpic as $value):?>

                                              <div class="col-xs-6 col-md-3">
                                                  <a href="#" class="thumbnail">
                                                      <img src="../../backend/web/uploads/<?=$value->picture?>" alt="">
                                                  </a>
                                                  <div class="btn btn-default" data-var="<?=$value->id?>" onclick="removepic($(this));">ลบ</div>
                                              </div>

                                              <?php //echo Html::img("../../frontend/web/img/screenshots/".$value->filename,['width'=>'10%','class'=>'thumbnail']) ?>
                                          <?php endforeach;?></div>
                                  </div>
                              <?php endif;?>

                          </div>
                      </div>
                            <div class="row">
                                <div class="col-ltg-12">
                                    <?php

                                    echo FileInput::widget([
                                    'model' => $modelfile,
                                    'attribute' => 'file[]',
                                    'options' => ['multiple' => true],
                                        'pluginOptions' => [
                                                'allowUpload'=>false,
                                        ]
                                    ]);
                                    ?>
                                </div>
                            </div>
                           <hr />
                           <p><h3>กำหนดราคาตามผู้ขาย</h3></p>
                          <div class="row">
                              <div class="col-lg-8">
                                  <table class="table table-striped table-list">
                                      <thead>
                                         <tr>
                                             <th>#</th>
                                             <th>ผู้ขาย</th>
                                             <th>ราคา</th>
                                             <th></th>
                                         </tr>
                                      </thead>
                                      <tbody>
                                      <?php if($model->isNewRecord):?>
                                        <tr>

                                            <td><span class="line-no"></span></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="vendor_code" style="border: none;padding: 5px 5px 5px 5px;width: 100%;background:transparent;text-align: left" name="vendor_code[]"  placeholder="ค้นหารหัส...">
                                                    <input type="hidden" class="vendor_id" name="vendor_id[]" value="">
                                                    <span class="input-group-btn">
                                    <div class="btn btn-default btn-search-item" style="border: none;background: transparent;"  onclick="findItem($(this));"><i class="fa fa-search-plus"></i></div>
                                </span>
                                                </div>
                                            </td>
                                            <td><input type="text" class="form-control line-price" name="line_price[]" value="0"></td>
                                            <td>
                                                <i class="fa fa-minus-circle text-danger remove-line" style="cursor: pointer;vertical-align: middle;" onclick="removeline($(this));"></i>
                                                <i class="fa fa-plus-circle text-success add-line" style="cursor: pointer;vertical-align: middle;" onclick="addLine($(this));" ></i>
                                            </td>
                                        </tr>
                                      <?php else:?>
                                      <?php $num = 0;?>
                                         <?php if(count($modelprice)>0):?>
                                         <?php foreach($modelprice as $value):?>
                                              <?php $num = $num +1;?>
                                          <tr>

                                              <td><span class="line-no"><?=$num?></span></td>
                                              <td>
                                                  <div class="input-group">
                                                      <input type="text" class="vendor_code" style="border: none;padding: 5px 5px 5px 5px;width: 100%;background:transparent;text-align: left" name="vendor_code[]" value="<?=\backend\models\Suplier::findName($value->vendor_id)?>"  placeholder="ค้นหารหัส...">
                                                      <input type="hidden" class="vendor_id" name="vendor_id[]" value="<?=$value->vendor_id?>">
                                                      <span class="input-group-btn">
                                    <div class="btn btn-default btn-search-item" style="border: none;background: transparent;"  onclick="findItem($(this));"><i class="fa fa-search-plus"></i></div>
                                </span>
                                                  </div>
                                              </td>
                                              <td><input type="text" class="form-control line-price" name="line_price[]" value="<?=$value->price?>"></td>
                                              <td>
                                                  <i class="fa fa-minus-circle text-danger remove-line" style="cursor: pointer;vertical-align: middle;" onclick="removeline($(this));"></i>
                                                  <i class="fa fa-plus-circle text-success add-line" style="cursor: pointer;vertical-align: middle;" onclick="addLine($(this));" ></i>
                                              </td>
                                          </tr>
                                         <?php endforeach;?>

                                         <?php else:?>
                                             <tr>

                                                 <td><span class="line-no"></span></td>
                                                 <td>
                                                     <div class="input-group">
                                                         <input type="text" class="vendor_code" style="border: none;padding: 5px 5px 5px 5px;width: 100%;background:transparent;text-align: left" name="vendor_code[]"  placeholder="ค้นหารหัส...">
                                                         <input type="hidden" class="vendor_id" name="vendor_id[]" value="">
                                                         <span class="input-group-btn">
                                    <div class="btn btn-default btn-search-item" style="border: none;background: transparent;"  onclick="findItem($(this));"><i class="fa fa-search-plus"></i></div>
                                </span>
                                                     </div>
                                                 </td>
                                                 <td><input type="text" class="form-control line-price" name="line_price[]" value="0"></td>
                                                 <td>
                                                     <i class="fa fa-minus-circle text-danger remove-line" style="cursor: pointer;vertical-align: middle;" onclick="removeline($(this));"></i>
                                                     <i class="fa fa-plus-circle text-success add-line" style="cursor: pointer;vertical-align: middle;" onclick="addLine($(this));" ></i>
                                                 </td>
                                             </tr>
                                         <?php endif;?>
                                      <?php endif;?>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      <hr />

                        <div class="col-md-8 col-md-offset-4">
                           <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
                           <?php if(!$model->isNewRecord):?>
                            <div class="btn btn-default"><a href="<?=Url::to(['product/view/','id'=>$model->id],true)?>">ดูรายละเอียด</a></div>
                          <?php endif;?>
                            <div class="btn btn-danger"><a style="color: #FFF" href="<?=Url::to(['product/index'],true)?>">ยกเลิก</a></div>
                        </div>
                  </div>
    </div>

    <?php ActiveForm::end(); ?>



</div>
<div id="findModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-search-plus text-primary"></i> <h3><b>ค้นหารหัสผู้ขาย</b></h3></h4>
            </div>
            <div class="modal-body">
                <input type="text" placeholder="ใส่คำค้นแล้วกด Enter" class="form-control itemsearch" name="itemsearch" >
                <br>
                <table class="table table-striped table-hover table-pop">
                    <thead>
                    <tr style="background-color: #00b488;color: #FFF;">
                        <th>รหัส</th>
                        <th>ชื่อ</th>
                    </tr>
                    </thead>
                    <tbody>
                       <?php if($vendorlist):?>
                       <?php foreach($vendorlist as $value):?>
                           <tr ondblclick="getitem($(this));">
                               <td>
                                   <input type="hidden" class="recid" name="sup_id" value="<?=$value->id?>">
                                   <?=$value->vendor_code?>
                               </td>
                               <td>
                                   <?=$value->name?>
                               </td>
                           </tr>
                       <?php endforeach;?>
                       <?php endif;?>
                    </tbody>
                </table>
                <div class="modal-error" style="display: none;">
                    <i class="fa fa-exclamation-triangle text-danger"> ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง</i>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-ok" data-dismiss="modal">ตกลง</button>
            </div>
        </div>
    </div>
</div>
<?php
$url_to_del_pic = Url::to(['product/deletepic'],true);
 $js =<<<JS
  $(function() {
    
  });
function addLine(e) {
   var tr = $(".table-list tbody tr:last");
        var clone = tr.clone();
        tr.closest("tr").find(".add-line").remove();
        clone.closest("tr").find(".vendor_code").val("");
        clone.closest("tr").find(".line-price").val("");
        tr.after(clone);
        linenum(); 
}
function removeline(e){
    var n = $(".table-list tbody tr").length;
   
   if(n==1){return false;}
    e.parent().parent().remove();
     var tr = $(".table-list tbody tr:last");
     var x = tr.closest("tr").find("td:eq(2)").val();

     tr.closest("tr").find("td:eq(3)").append('<i class="fa fa-plus-circle text-success add-line" style="cursor: pointer;vertical-align: middle;" onclick="addLine($(this));" ></i>');
}
function findItem(e) {
      currow = e.parent().parent().parent().parent().index();
     // alert(currow);
      $("#findModal").modal("show");
  }
  function getitem(e) {
    var prodcode = e.closest("tr").find("td:eq(0)").text();
    var prodname = e.closest("tr").find("td:eq(1)").text();
    var prodid = e.closest("tr").find(".recid").val();
    
    $(".table-list tbody tr").each(function() {
        //alert('niran');
        if($(this).index() == currow){
              $(this).closest('tr').find(".vendor_code").val(prodname.trim());
              $(this).closest('tr').find(".vendor_id").val(prodid);
              $(this).closest('tr').find('.line-price').focus().select();
        }
    });
    $("#findModal").modal("hide");
      
   }
    function linenum() {
    var nums = 0;
     $(".table-list tbody tr").each(function() {
         nums+=1;
      $(this).closest('tr').find('.line-no').text(nums);
        
    });
  }
  function removepic(e){
   // alert(e.attr("data-var"));return;
    if(confirm("ต้องการลบรูปภาพนี้ใช่หรือไม่")){
        $.ajax({
           'type':'post',
           'dataType':'html',
           'url':"$url_to_del_pic",
           'data': {'pic_id':e.attr("data-var")},
           'success': function(data) {
             location.reload();
           }
        });
    }
  }
JS;

 $this->registerJs($js,static::POS_END);

?>
            