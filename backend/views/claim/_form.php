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
                        <div class="col-lg-4">

                                <?= $form->field($model, 'sale_no',[
                                    'template' => '{label}<div class="input-group">{input}
                                                   <span style="cursor: pointer" class="input-group-addon btn-find" onclick="find_so($(this));"><i class="fa fa-search"></i></span></div>{error}{hint}'
                                ])->label() ?>

                        </div>

                    </div>
            <div class="row">
                <div class="col-lg-4">
                    <?php echo $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label(false) ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-line">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>รหัสสินค้า</th>
                            <th>ชื่อ</th>
                            <th>จำนวน</th>
                            <th>สาเหตุ</th>
                            <th>เลขที่อ้างอิง</th>
                            <th>-</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="form-group">
                    <input type="submit" value="Save" class="btn btn-success">
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
                         html +="<tr ondblclick='getitem($(this));'><td>"+data[i]['product_code']+"</td><td>"+data[i]['name']+"<input type='hidden' class='recid' value='"+data[i]['sale_id']+"'/></td><td>"+data[i]['qty']+"</td></tr>"
                 
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
JS;

$this->registerJs($js,static::POS_END);

?>
