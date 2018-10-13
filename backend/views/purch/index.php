<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use lavrentiev\widgets\toastr\Notification;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'รายการซื้อ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="productcat-index">
    <?php $session = Yii::$app->session;
    if ($session->getFlash('msg')): ?>
        <!-- <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <?php //echo $session->getFlash('msg'); ?>
      </div> -->
        <?php echo Notification::widget([
            'type' => 'success',
            'title' => 'แจ้งผลการทำงาน',
            'message' => $session->getFlash('msg'),
            //  'message' => 'Hello',
            'options' => [
                "closeButton" => false,
                "debug" => false,
                "newestOnTop" => false,
                "progressBar" => false,
                "positionClass" => "toast-top-center",
                "preventDuplicates" => false,
                "onclick" => null,
                "showDuration" => "300",
                "hideDuration" => "1000",
                "timeOut" => "6000",
                "extendedTimeOut" => "1000",
                "showEasing" => "swing",
                "hideEasing" => "linear",
                "showMethod" => "fadeIn",
                "hideMethod" => "fadeOut"
            ]
        ]); ?>
    <?php endif; ?>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>




    <div class="panel panel-headline">
        <div class="panel-heading">
            <div class="btn-group">
                <?= Html::a(Yii::t('app', '<i class="fa fa-plus"></i> สร้างรายการซื้อ'), ['create'], ['class' => 'btn btn-success']) ?>
               <div class="btn btn-default"><i class="fa fa-retweet"></i> รับสินค้า</div>
            </div>

            <h4 class="pull-right"><?=$this->title?> <i class="fa fa-cubes"></i><small></small></h4>
            <!-- <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
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
            <div class="row">
                <div class="col-lg-9">
                    <div class="form-inline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="pull-right">
                        <form id="form-perpage" class="form-inline" action="<?=Url::to(['purch/index'],true)?>" method="post">
                            <div class="form-group">
                                <label>แสดง </label>
                                <select class="form-control" name="perpage" id="perpage">
                                    <option value="20" <?=$perpage=='20'?'selected':''?>>20</option>
                                    <option value="50" <?=$perpage=='50'?'selected':''?> >50</option>
                                    <option value="100" <?=$perpage=='100'?'selected':''?>>100</option>
                                </select>
                                <label> รายการ</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-responsive">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'emptyCell'=>'-',
        'layout'=>'{items}{summary}{pager}',
        'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
        'showOnEmpty'=>false,
        'tableOptions' => ['class' => 'table table-hover'],
        'emptyText' => '<div style="color: red;align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','contentOptions' => ['style' => 'vertical-align: middle;text-align: center;']],

            //   'id',
            [
                'attribute'=>'purch_no',
                'headerOptions' => ['style' => 'text-align: left'],
                'contentOptions' => ['style' => 'vertical-align: middle'],
            ],
            [
                'attribute'=>'purch_date',
                'headerOptions' => ['style' => 'text-align: left'],
                'contentOptions' => ['style' => 'vertical-align: middle'],
            ],
            [
                'attribute' => 'vendor_id',
                'headerOptions' => ['style' => 'text-align: left'],
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'value'=>function($data){
                    return \backend\models\Suplier::findName($data->vendor_id);
                }
            ],
            [
                'attribute'=>'purch_total',
                'headerOptions' => ['style' => 'text-align: left'],
                'contentOptions' => ['style' => 'vertical-align: middle'],
            ],
            [
                'label'=>'ยอดค้าง',
                'headerOptions' => ['style' => 'text-align: left'],
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'value' => function($data){
                   return \backend\models\Purch::getRecSum($data->id);
                }
            ],
            //'status',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',

            [
                'attribute'=>'status',
                'contentOptions' => ['style' => 'vertical-align: middle;text-align: left;'],
                'format' => 'raw',
                'value'=>function($data){
                    return $data->status === 1 ? '<div onclick="showpop($(this));" style="cursor: pointer" class="label label-success">รอรับเข้า</div>':'<div  style="cursor: pointer" class="label label-default">รับสินค้าแล้ว</div>';
                }
            ],
            [

                'header' => '',
                'headerOptions' => ['style' => 'text-align:center;','class' => 'activity-view-link',],
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'text-align: right'],
                'buttons' => [
                    'view' => function($url, $data, $index) {
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ];
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open btn btn-default"></span>', $url, $options);
                    },
                    'update' => function($url, $data, $index) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'id'=>'modaledit',
                        ]);
                        return $data->status == 1? Html::a(
                            '<span class="glyphicon glyphicon-pencil btn btn-default"></span>', $url, [
                            'id' => 'activity-view-link',
                            //'data-toggle' => 'modal',
                            // 'data-target' => '#modal',
                            'data-id' => $index,
                            'data-pjax' => '0',
                            // 'style'=>['float'=>'rigth'],
                        ]):'';
                    },
                    'delete' =>function($url, $data, $index) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            //'data-method' => 'post',
                            //'data-pjax' => '0',
                            'data-url'=>$url,
                            'onclick'=>'recDelete($(this));'
                        ]);
                        return $data->status <=1? Html::a('<span class="glyphicon glyphicon-trash btn btn-default"></span>', 'javascript:void(0)', $options):'';
                    }
                ]
            ],
        ],
    ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
    <div id="recModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-search-plus text-primary"></i> รับสินค้าเข้าคลัง</h4>
                </div>
                <div class="modal-body">

                    <table class="table table-striped table-hover table-list" style="display: none;">
                        <thead>
                        <tr style="background-color: #00b488;color: #FFF;">
                            <th>รหัส</th>
                            <th>ชื่อ</th>
                            <th>จำนวนสั่ง</th>
                            <th>จำนวนรับ</th>
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
                    <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-success btn-ok" data-dismiss="modal">ตกลง</button>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerJsFile( '@web/js/sweetalert.min.js',['depends' => [\yii\web\JqueryAsset::className()]],static::POS_END);
$this->registerCssFile( '@web/css/sweetalert.css');

$url_to_find = Url::to(['purch/getlist'],true);
$url_to_rec = Url::to(['purch/purchrec'],true);
$js = <<<JS
   $(function() {
     $(".btn-ok").click(function() {
          var purch_id = [];
          var product_id = [];
          var rec_qty = [];
         $(".table-list tbody tr").each(function() {
            purch_id.push($(this).closest("tr").find(".purchid").val());
            product_id.push($(this).closest("tr").find(".prodid").val());
            rec_qty.push($(this).closest("tr").find(".line_qty").val());
         });
         if(product_id.length > 0){
             //alert(purch_id);
             $.ajax({
                'type':'post',
                'dataType': 'json',
                'url': "$url_to_rec",
                'data': {'poid':purch_id,'productid':product_id,'qty':rec_qty},
                'success': function(data){
                    alert(data);
                }
             });
         }
      });
   });
  function showpop(e) {
      $("#recModal").modal("show");
      showpo(e.parents("tr").data("key"));
      
      
  }
  function showpo(poid) {
    if(poid != ""){
       //alert(poid);
        $.ajax({
              'type':'post',
              'dataType': 'json',
              'url': "$url_to_find",
              'data': {'purchid': poid},
              'success': function(data) {
               //  alert(data);return;
                 if(data.length == 0){
                      $(".table-list").hide();
                     $(".modal-error").show();
                 }else{
                     $(".modal-error").hide();
                     $(".table-list").show();
                     var html = "";
                     for(var i =0;i<=data.length -1;i++){
                         html +="<tr ondblclick='getitem($(this));'><td style='vertical-align: middle;'>"+
                         data[i]['product_code']+"</td>" +
                          "<td style='vertical-align: middle;'>"+data[i]['name']+"<input type='hidden' class='recid' value='"+
                         data[i]['id']+"'/><input type='hidden' class='purchid' value='"+
                         data[i]['purch_id']+"'/><input type='hidden' class='prodid' value='"+
                         data[i]['product_id']+"'/></td>" +
                          "<td style='vertical-align: middle;'>"+data[i]['qty']+"</td>" +
                          "<td style='vertical-align: middle;'>" +
                           "<input type='text' class='form-control line_qty' style='width: 50%' value='"+data[i]['remain_qty']+"' /></td></tr>"
                     }
                     $(".table-list tbody").html(html);
                     
                 }
              }
            });
    }
  }
   $(function(){
        $("#perpage").change(function(){
            $("#form-perpage").submit();
        });
    });

   function recDelete(e){
        //e.preventDefault();
        var url = e.attr("data-url");
        alert(url);
        swal({
              title: "ต้องการลบรายการนี้ใช่หรือไม่",
              text: "",
              type: "warning",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true
            }, function () {
              e.attr("href",url); 
              e.toggle("click");        
        });
    }
JS;
$this->registerJs($js,static::POS_END);
?>