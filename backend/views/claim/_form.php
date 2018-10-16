<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use toxor88\switchery\Switchery;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\helpers\Url;

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
<!--                        <div class="col-lg-4">-->

                                <?php //echo $form->field($model, 'sale_no',[
                                   // 'template' => '{label}<div class="input-group">{input}
                                  //                 <span style="cursor: pointer" class="input-group-addon btn-find" onclick="find_so($(this));"><i class="fa fa-search"></i></span></div>{error}{hint}'
                        //        ])->label() ?>

<!--                        </div>-->
                        <div class="col-lg-4">
                            <?php //echo $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label() ?>
                        </div>

                    </div>
            <div class="row">

            </div>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-line">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 20%">รหัสสินค้า</th>
                            <th>ชื่อ</th>
                            <th>จำนวน</th>
                            <th>สาเหตุ</th>
                            <th>เลขที่อ้างอิง</th>
                            <th>-</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if($model->isNewRecord):?>
                                   <tr>
                                       <td style="width: 5%;padding-top: 15px;" class="line-no"></td>
                                       <td style="width: 20%">
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
                                           <input type="text" name="line_cause[]" class="form-control line-cause" value="">
                                       </td>
                                       <td>
                                           <input style="border: none;padding: 5px 5px 5px 5px;width: 100%;background:transparent;text-align: left" type="text" readonly name="line_ref[]" class="form-control line-ref" value="">
                                       </td>
                                       <td>
                                           <i class="fa fa-minus-circle text-danger remove-line" style="cursor: pointer;vertical-align: middle;" onclick="removeline($(this));"></i>
                                       </td>
                                   </tr>
                            <?php else:?>
                            <?php
                                $i = 0;
                                foreach ($modelline as $value):
                            ?>
                                <?php $i+=1; ?>
                                    <tr>
                                        <td style="width: 5%;padding-top: 15px;" class="line-no"><?=$i?></td>
                                        <td style="width: 20%">
                                            <div class="input-group">
                                                <input type="text" class="product_code" style="border: none;padding: 5px 5px 5px 5px;width: 100%;background:transparent;text-align: left" name="product_code[]"  placeholder="ค้นหารหัส..." value="<?=\backend\models\Product::findProductCode($value->product_id)?>">
                                                <input type="hidden" class="product_id" name="product_id[]" value="<?=$value->product_id?>">
                                                <span class="input-group-btn">
                                            <div class="btn btn-default btn-search-item" style="border: none;background: transparent;"  onclick="findItem($(this));"><i class="fa fa-search-plus"></i></div>
                                        </span>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" readonly name="product_name[]" class="form-control product-name" value="<?=\backend\models\Product::findName($value->product_id)?>">
                                        </td>
                                        <td>
                                            <input style="border: none;padding: 5px 5px 5px 5px;width: 100%;background:transparent;text-align: right" type="text" name="line_qty[]" class="form-control line-qty" value="<?=$value->qty?>" onchange="linecal($(this));">
                                        </td>
                                        <td>
                                            <input type="text" name="line_cause[]" class="form-control line-cause" value="<?=$value->problem?>">
                                        </td>
                                        <td>
                                            <input style="border: none;padding: 5px 5px 5px 5px;width: 100%;background:transparent;text-align: left" type="text" readonly name="line_ref[]" class="form-control line-ref" value="<?=$value->sale_ref?>">
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
                </div>
            </div>

            <div class="form-group">
                    <input type="submit" value="Save" class="btn btn-success">
                <div class="btn btn-primary"> ยืนยันการทำรายการ</div>
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
                <h4 class="modal-title"><i class="fa fa-search-plus text-primary"></i> ค้นหารใบสั่งซื้อ</h4>
            </div>
            <div class="modal-body">
                <input type="text" placeholder="ใส่คำค้นแล้วกด Enter" class="form-control itemsearch" name="itemsearch" >
                <br>
                <table class="table table-striped table-hover table-list" style="display: none;">
                    <thead>
                    <tr style="background-color: #00b488;color: #FFF;">
                        <th>รหัส</th>
                        <th>ชื่อ</th>
                        <th>จำนวน</th>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
<?php
$url_to_find = Url::to(['claim/findso'],true);
$js = <<<JS
 $(function() {
     linenum();
      $(".btn-add-line").click(function() {
       var tr = $(".table-line tbody tr:first");
       if(tr.closest("tr").find(".product_code").val()== "" || tr.closest("tr").find(".line-qty").val()== "0")return;
       var clone = tr.clone();
       clone.closest("tr").find(".product_code").val("");
       clone.closest("tr").find(".product-name").val("");
       clone.closest("tr").find(".line-qty").val("0");
       clone.closest("tr").find(".line-cause").val("");
       clone.closest("tr").find(".line-ref").val("");
    
       tr.after(clone);
       linenum();
    });
    $(".itemsearch").change(function() {
        var txt = $(this).val();
        $.ajax({
           'type':'post',
           'dataType': 'json',
           'url': "$url_to_find",
           'data': {'so': txt},
           'success': function(data){
               if(data.length){
                    
                    var html = "<tr><td>niran</td></tr>";
                     for(var i =0;i<=data.length -1;i++){
                        // alert(data[i]['product_code']);
                         html +="<tr ondblclick='getitem($(this));'><td>"+data[i]['product_code']+"</td><td>"+data[i]['name']+"<input type='hidden' class='recid' value='"+data[i]['sale_id']+"'/><input type='hidden' class='prodid' value='"+data[i]['product_id']+"'/></td><td>"+data[i]['qty']+"</td></tr>"
                 
                     }
                     $("table.table-list").show();
                     $("table.table-list tbody").html(html);
               }else{
                   alert("no");
               }
              
           }
        });
    })
 })
 function find_so(e){
    $("#findModal").modal("show");
 }
  function getitem(e) {
    
    var prodcode = e.closest("tr").find("td:eq(0)").text();
    var prodname = e.closest("tr").find("td:eq(1)").text();
    var saleid = e.closest("tr").find(".recid").val();
    var line_ref = $(".itemsearch").val();
    var prodid = e.closest("tr").find(".prodid").val();
    $(".table-line tbody tr").each(function() {
        //alert(prodname);
        if($(this).index() == currow){
              $(this).closest('tr').find(".product_code").val(prodcode);
              $(this).closest('tr').find(".product_id").val(prodid);
              $(this).closest('tr').find(".product-name").val(prodname);
              $(this).closest('tr').find('.line-qty').focus().select();
              $(this).closest('tr').find('.line-ref').val(line_ref);
        }
    });
    $("#findModal").modal("hide");
  }
  function linenum() {
      var nums = 0;
     $(".table-line tbody tr").each(function() {
         nums+=1;
      $(this).closest('tr').find('.line-no').text(nums);
        
    });
  }
  function findItem(e) {
      currow = e.parent().parent().parent().parent().index();
     // alert(currow);
      $("#findModal").modal("show");
  }
  function removeline(e) {
    if(confirm("ต้องการลบรายการนี้ใช่หรือ")){
          var cnt = $("table.table-line tbody tr").length;
          if(cnt == 1){
              $("table.table-line tbody tr").each(function(){
                  
              });
          }else{
               e.parent().parent().remove();
          }
          
    }
  }
JS;

$this->registerJs($js,static::POS_END);

?>
