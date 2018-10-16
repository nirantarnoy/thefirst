<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\Sale */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="x_title">
            <h3><i class="fa fa-money"></i> <?=$this->title?> </h3>
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
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">เลขที่ <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <?= $form->field($model, 'sale_no')->textInput(['maxlength' => true,'class'=>'form-control','value'=>$model->isNewRecord?$runno:$model->sale_no,'readonly'=>'readonly'])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <?php $model->trans_date = $model->isNewRecord?date('d-m-Y'):date('d-m-Y',$model->trans_date) ?>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">วันที่ <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-12 col-xs-12">
                            <?= $form->field($model, 'trans_date')->widget(DatePicker::className(),[
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
                            <?= $form->field($model, 'customer_id')->widget(Select2::className(),[
                                'data'=>ArrayHelper::map(\backend\models\Customer::find()->all(),'id','first_name'),
                                'options' => ['placeholder'=>'เลือกลูกค้า'],
                            ])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ประเภท<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <?= $form->field($model, 'sale_type_id')->widget(Select2::className(),[
                                'data'=>ArrayHelper::map(\backend\helpers\SaleType::asArrayObject(),'id','name'),
                                'options' => [],
                            ])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">สถานะ
                        </label>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <label class="label label-success" for="">
                                เปิด
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        </label>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                           <div class="btn btn-default btn-cal"><i class="fa fa-calculator"></i> คำนวนค่างวด</div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="total" class="total" value="">


    <?php //echo $form->field($model, 'payment_type_id')->textInput() ?>

    <?php //echo $form->field($model, 'discount_per')->textInput() ?>

    <?php //echo $form->field($model, 'discount_amount')->textInput() ?>

    <?php //echo $form->field($model, 'sale_total')->textInput() ?>

    <?php //echo $form->field($model, 'sale_total_text')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'status')->textInput() ?>

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
                                <input type="text" class="product_code" style="border: none;padding: 5px 5px 5px 5px;width: 100%;background:transparent;text-align: left" name="product_code[]"  placeholder="ค้นหารหัส...">
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
                                    <input type="text" name="product_code[]" class="form-control product_code" placeholder="ค้นหารหัส..." value="<?=\backend\models\Product::findProductCode($value->product_id)?>">
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
                                <input style="text-align: right;" name="line_total[]" readonly type="text" class="form-control line-total" value="<?=$value->line_total?>">
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
                        <?php if($model->status <=1):?>
                            <div class="btn btn-default btn-add-line"><i class="fa fa-plus-circle"></i> เพิ่มรายการ </div>
                        <?php endif;?>
                    </td>
                </tr>
                </tfoot>
            </table>

            <?php if($model->status <=1):?>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="submit" value="Save" class="btn btn-success">
                            </div>
                        </div>
            <?php endif;?>


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
                    <h4 class="modal-title"><i class="fa fa-search-plus text-primary"></i> <h3><b>ค้นหารหัสสินค้า</b></h3></h4>
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

    <div id="loanModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-calculator text-primary"></i> คำนวนงวดการชำระ</h4>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><b>จำนวนงวด</b></p>

                                    <div class="btn-group">
                                        <div class="btn btn-primary btn-three" data-var="3"> 3 เดือน </div>
                                        <div class="btn btn-primary btn-six" data-var="6"> 6 เดือน </div>
                                        <div class="btn btn-primary btn-nine" data-var="9"> 9 เดือน </div>
                                        <div class="btn btn-primary btn-twel" data-var="12"> 12 เดือน </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p></p>
                                    <input type="number" name="all_period" class="all_period form-control all-period" min="0" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><b>อัตราดอกเบี้ย (%)</b></p>
                                    <input type="text" name="per_fee" class="per_fee form-control" value="0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><b>ชำระงวดละ</b></p>
                                    <input type="text" name="per_qty" class="per_qty form-control" value="0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <p><b>ชำระทุกวันที่</b></p>
                                    <input type="number" name="pay_day" class="pay_day form-control" min="1" value="0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <p><b>ค่าปรับล่าช้า (วันละ)</b></p>
                                    <input type="text" name="fee_amount" class="fee_rate form-control" min="0" value="0">
                                </div>
                            </div>


                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h2><small><b>รวมยอดขาย</b></small> <span class="total_pop"></span> </h2>
                                    <input type="hidden" name="total_amount" class="total-amount" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><b>วันที่ต้องชำระงวดแรก</b></p>
                                    <?php
                                      echo DatePicker::widget([
                                          'name'=>'start_date',
                                          'id'=>'s_date',
                                         // 'value' => date('d-m-Y'),
                                          'options' => [
                                                  'onchange'=>'
                                                      var d = new Date($(this).val()); 
                                                       
                                                      //$(this).val(d.getDate() + \'-\' + d.getMonth() + \'-\' +  d.getFullYear());
                                                      d.setMonth(d.getMonth() + 6);
                                                      //alert(d.getDate() + \'-\' + d.getMonth() + \'-\' +  d.getFullYear());
                                                        var day = d.getDate();
                                                        var month = d.getMonth() + 1;
                                                        var year = d.getFullYear();
                                                        if (day < 10) {
                                                            day = "0" + day;
                                                        }
                                                        if (month < 10) {
                                                            month = "0" + month;
                                                        }
                                                        var dates = day + "-" + month + "-" + year;
                                                     $("#n_date").val(dates);
                                                  '
                                          ],
                                          'pluginOptions' => [
                                              'todayHighlight' => true,
                                                  'format'=>'dd-mm-yyyy'
                                          ]

                                      ]);
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><b>วันที่ต้องชำระงวดสุดท้าย</b></p>
                                    <?php
                                    echo DatePicker::widget([
                                        'name'=>'end_date',
                                       // 'value' => date('d-m-Y'),
                                        'id'=>'n_date',
                                        'pluginOptions' => [
                                            'format'=>'dd-mm-yyyy'
                                        ]

                                    ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-loan-ok" data-dismiss="modal">ตกลง</button>
                    <button type="button" class="btn btn-default btn-loan-cancel" data-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

<?php
$url_to_find = Url::to(['purch/finditem'],true);
$url_to_loan = Url::to(['sale/loan'],true);
$url_to_find_loan = Url::to(['sale/findloan'],true);
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
     $(".btn-cal").click(function() {
      calall();
      //$("#loanModal").modal("show").find(".total_pop").text(parseFloat($(".total").val()).toFixed(0));
      //$("#loanModal").find(".total-amount").val($(".total").val());
      
      var saleid = "$model->id";
      
      $.ajax({
              'type':'post',
              'dataType': 'json',
              'url': "$url_to_find_loan",
              'async': false,
              'data': {'saleid': saleid},
              'success': function(data) {
                 //alert(data['sale_id']);return;
                  $("#loanModal").modal("show").find(".total_pop").text(parseFloat($(".total").val()).toFixed(0));
                  $("#loanModal").find(".total-amount").val($(".total").val());
                  $("#loanModal").find(".all_period").val(data['period']);
                  $("#loanModal").find(".per_fee").val(data['loan_percent']);
                  $("#loanModal").find(".per_qty").val(data['payment_per']);
                  $("#loanModal").find(".pay_day").val(data['pay_ever_day']);
                  $("#loanModal").find(".fee_rate").val(data['fee_rate']);
           
              }
            });
      
      
      
    });
     
     $(".btn-three,.btn-six,.btn-nine,.btn-twel").click(function() {
        var n = $(this).attr("data-var");
        var total = $(".total-amount").val();
        $(".all-period").val(n);
        $(".per_qty").val((total / n));
     });
     
     $(".per_fee").change(function() {
        var period = $(".all-period").val();
        var total = $(".total-amount").val();
        var per = $(this).val();
        
        var normal = (total / period);
        var all_interest = (total * per) / 100;
        var per_interest = (all_interest / period);
        var grand_total = normal + per_interest;
        $(".per_qty").val(grand_total);
        
     });
     
     $(".btn-loan-ok").click(function(){
        var saleid = "$model->id";
        var allperiod = $(".all_period").val();
        var loanper = $(".per_fee").val();
        var perqty = $(".per_qty").val();
        var payday = $(".pay_day").val();
        var feerate = $(".fee_rate").val();
        var sdate = $("#s_date").val();
        var ndate = $("#n_date").val();
        
      //  alert(ndate);return;
        
        $.ajax({
              'type':'post',
              'dataType': 'html',
              'url': "$url_to_loan",
              'data': {'saleid': saleid,'allperiod': allperiod,'loanper': loanper,'perqty': perqty,'payday': payday,'feerate':feerate,'sdate': sdate,'ndate': ndate},
              'success': function(data) {
                // alert(data);return;
                
              }
            });
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
    calall();
  }
  function calall(){
      var total_all = 0;
      $(".table-item tbody tr").each(function() {
         total_all = total_all + parseFloat($(this).closest("tr").find(".line-total").val());
      });
      $(".total").val(total_all);
  }
  function linenum() {
      var nums = 0;
     $(".table-item tbody tr").each(function() {
         nums+=1;
      $(this).closest('tr').find('.line-no').text(nums);
        
    });
  }
JS;
$this->registerJs($js,static::POS_END);
?>