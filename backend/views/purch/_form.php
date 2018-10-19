<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Purch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="x_title">
            <h3><i class="fa fa-shopping-cart"></i> <?=$this->title?> <span><small><?=$model->status <=1?"<label class='label label-success'> เปิด </label>":"<label class='label label-danger'> ปิด </label>"?></small></span></h3>
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

            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">เลขที่ <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <?= $form->field($model, 'purch_no')->textInput(['maxlength' => true,'class'=>'form-control','value'=>$model->isNewRecord?$runno:$model->purch_no])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <?php $model->purch_date = $model->isNewRecord?date('d-m-Y'):$model->purch_date ?>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">วันที่ <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <?= $form->field($model, 'purch_date')->widget(DatePicker::className(),[
                                    'value' => date('d-m-Y'),
                            ])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ผู้ขาย <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <?= $form->field($model, 'vendor_id')->widget(Select2::className(),[
                                    'data'=>ArrayHelper::map(\backend\models\Suplier::find()->all(),'id','name'),
                                    'options' => ['placeholder'=>'เลือกผู้ขาย'],
                            ])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-item">
                <thead>
                   <tr style="background-color: #00b488;color: #FFF">
                       <th>#</th>
                       <th>รหัส</th>
                       <th>ชื่อ</th>
                       <th style="text-align: right">จำนวน</th>
                       <th style="text-align: right">ราคา</th>
                       <th style="text-align: right">รวม</th>
                       <th style="text-align: center">-</th>
                   </tr>
                </thead>
                <tbody>
                <?php if($model->isNewRecord):?>
                    <tr>
                        <td style="width: 5%;padding-top: 15px;" class="line-no"></td>
                        <td style="width: 30%">
                            <div class="input-group">
                                <input type="text" onchange="productChange($(this))" class="product_code" style="border: none;padding: 5px 5px 5px 5px;width: 100%;background:transparent;text-align: left" name="product_code[]"  placeholder="ค้นหารหัส...">
                                <input type="hidden" class="product_id" name="product_id[]" value="">
                                <span class="input-group-btn">
                                    <div class="btn btn-default btn-search-item" style="border: none;background: transparent;"  onclick="findItem($(this));"><i class="fa fa-search-plus"></i></div>
                                </span>
                            </div>
                        </td>
                        <td>
                            <input type="text" readonly name="product_name[]" class="form-control product-name" value="">
                        </td>
                        <td>
                            <input style="border: none;padding: 5px 5px 5px 5px;width: 100%;background:transparent;text-align: right" type="text" name="line_qty[]" class="form-control line-qty" value="0" onchange="linecal($(this));">
                        </td>
                        <td>
                            <input style="border: none;padding: 5px 5px 5px 5px;width: 100%;background:transparent;text-align: right" type="text" name="line_price[]" class="form-control line-price" value="0" onchange="linecal($(this));">
                        </td>
                        <td>
                            <input style="border: none;padding: 5px 5px 5px 5px;width: 100%;background:transparent;text-align: right" name="line_total[]" readonly type="text" class="form-control line-total" value="0">
                        </td>
                        <td>
                            <i class="fa fa-minus-circle text-danger remove-line" style="cursor: pointer;vertical-align: middle;" onclick="removeline($(this));"></i>
                        </td>

                    </tr>
                <?php else:?>
                <?php foreach ($modelline as $value):?>
                    <tr>
                        <td style="width: 5%;padding-top: 15px;" class="line-no"></td>
                        <td style="width: 30%">
                            <div class="input-group">
                                <input type="text" onchange="productChange($(this))" name="product_code[]" class="form-control product_code" placeholder="ค้นหารหัส..." value="<?=\backend\models\Product::findProductCode($value->product_id)?>">
                                <input type="hidden" class="product_id" name="product_id[]" value="<?=$value->product_id?>">
                                <span class="input-group-btn">
                                    <div class="btn btn-default btn-search-item"  onclick="findItem($(this));"><i class="fa fa-search-plus"></i></div>
                                </span>
                            </div>
                        </td>
                        <td>
                            <input type="text" readonly name="product_name[]" class="form-control product-name" value="<?=\backend\models\Product::findName($value->product_id)?>">
                        </td>
                        <td>
                            <input style="text-align: right" type="text" name="line_qty[]" class="form-control line-qty" value="<?=$value->qty?>" onchange="linecal($(this));">
                        </td>
                        <td>
                            <input style="text-align: right" type="text" name="line_price[]" class="form-control line-price" value="<?=$value->price?>" onchange="linecal($(this));">
                        </td>
                        <td>
                            <input style="text-align: right;" name="line_total[]" readonly type="text" class="form-control line-total" value="<?=$value->line_amount?>">
                        </td>
                        <td>
                            <i class="fa fa-minus-circle text-danger remove-line" style="cursor: pointer;vertical-align: middle;" onclick="removeline($(this));"></i>
                        </td>

                    </tr>
                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
                <tfoot>
                  <tr>
                      <td colspan="7">
                          <div class="btn btn-default btn-add-line"><i class="fa fa-plus-circle"></i> เพิ่มรายการ </div>
                      </td>
                  </tr>
                </tfoot>
            </table>



            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="submit" value="Save" class="btn btn-success">
                </div>
            </div>

    <?php ActiveForm::end(); ?>

</div>
    </div>
</div>

<div id="findModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-search-plus text-primary"></i> ค้นหารหัสสินค้า</h4>
            </div>
            <div class="modal-body">
                <input type="text" placeholder="ใส่คำค้นแล้วกด Enter" class="form-control itemsearch" name="itemsearch" >
                <br>
                <table class="table table-striped table-hover table-list" style="display: none;">
                    <thead>
                    <tr style="background-color: #00b488;color: #FFF;">
                        <th>รหัส</th>
                        <th>ชื่อ</th>
                    </tr>
                    </thead>
                    <tbody>

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
$url_to_find = Url::to(['purch/finditem'],true);
$url_to_find_full = Url::to(['purch/finditemfull'],true);
$js=<<<JS
  $(function() {
      var currow = -1;
      linenum();
    $(".btn-add-line").click(function() {
       var tr = $(".table-item tbody tr:first");
       if(tr.closest("tr").find(".product_code").val()== "")return;
       var clone = tr.clone();
       clone.closest("tr").find(".product_code").val("");
       clone.closest("tr").find(".product-name").val("");
       clone.closest("tr").find(".line-qty").val("0");
       clone.closest("tr").find(".line-price").val("0");
       clone.closest("tr").find(".line-total").val("0");
       tr.after(clone);
       linenum();
    });
    $(".btn-ok").click(function() {
       $(".table-list tbody tr").each(function() {
           var id = $(this).find(".recid").val();
           //alert(id);
       })
    })
    $(".line-qty,.line-price").on("keypress",function(event){
       $(this).val($(this).val().replace(/[^0-9\.]/g,""));
       if((event.which != 46 || $(this).val().indexOf(".") != -1) && (event.which <48 || event.which >57)){event.preventDefault();}
    });
    $(".itemsearch").change(function(){
        if($(this).val()!=''){
            $.ajax({
              'type':'post',
              'dataType': 'json',
              'url': "$url_to_find",
              'data': {'txt': $(this).val()},
              'success': function(data) {
                // alert(data);return;
                 if(data.length == 0){
                      $(".table-list").hide();
                     $(".modal-error").show();
                 }else{
                     $(".modal-error").hide();
                     $(".table-list").show();
                     var html = "";
                     for(var i =0;i<=data.length -1;i++){
                         html +="<tr ondblclick='getitem($(this));'><td>"+data[i]['product_code']+"</td><td>"+data[i]['name']+"<input type='hidden' class='recid' value='"+data[i]['id']+"'/></td></tr>"
                       
                     }
                     $(".table-list tbody").html(html);
                     
                 }
              }
            });
        }
    });
  });
  function findItem(e) {
      currow = e.parent().parent().parent().parent().index();
     // alert(currow);
      $("#findModal").modal("show");
  }
  function removeline(e) {
    if(confirm("ต้องการลบรายการนี้ใช่หรือ")){
        e.parent().parent().remove();
    }
  }
  function getitem(e) {
    var prodcode = e.closest("tr").find("td:eq(0)").text();
    var prodname = e.closest("tr").find("td:eq(1)").text();
    var prodid = e.closest("tr").find(".recid").val();
    $(".table-item tbody tr").each(function() {
        //alert('niran');
        if($(this).index() == currow){
              $(this).closest('tr').find(".product_code").val(prodcode);
              $(this).closest('tr').find(".product_id").val(prodid);
              $(this).closest('tr').find(".product-name").val(prodname);
              $(this).closest('tr').find('.line-qty').focus().select();
        }
    });
    $("#findModal").modal("hide");
  }
  function linecal(e) {
    var qty = e.closest("tr").find(".line-qty").val();
    var price = e.closest("tr").find(".line-price").val();
    e.closest("tr").find(".line-total").val(parseFloat(qty)*parseFloat(price));
  }
  function linenum() {
      var nums = 0;
     $(".table-item tbody tr").each(function() {
         nums+=1;
      $(this).closest('tr').find('.line-no').text(nums);
        
    });
  }
  function productChange(e){
      if(e.val()!=''){
            $.ajax({
              'type':'post',
              'dataType': 'json',
              'url': "$url_to_find_full",
              'async': false,
              'data': {'txt': e.val()},
              'success': function(data) {
                 e.closest("tr").find(".product_id").val(data[0]['product_id']);
                 e.closest("tr").find(".product-name").val(data[0]['name']);
                 e.closest("tr").find(".line-price").val(data[0]['maxprice']);
                 e.closest("tr").find(".line-qty").focus().select();
              }
            });
        }
  }
JS;
$this->registerJs($js,static::POS_END);
?>
