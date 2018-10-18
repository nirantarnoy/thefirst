<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use lavrentiev\widgets\toastr\Notification;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'รายการขาย');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-index">
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
                <?= Html::a(Yii::t('app', '<i class="fa fa-plus"></i> สร้างการขาย'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
<!--            <div class="btn-group">-->
<!--                <div class="btn btn-default btn-print"><i class="fa fa-print"></i> พิมพ์ใบเสร็จ</div>-->
<!--            </div>-->
            <h4 class="pull-right"><?=$this->title?> <i class="fa fa-hourglass"></i><small></small></h4>
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
                        <form id="form-perpage" class="form-inline" action="<?=Url::to(['sale/index'],true)?>" method="post">
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
            ['class' => 'yii\grid\SerialColumn','contentOptions' => ['style' => 'vertical-align: middle']],
            [
                'attribute'=>'sale_no',
                'contentOptions' => ['style' => 'vertical-align: middle'],
            ],
            [
                'attribute'=>'trans_date',
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'value' => function($data){
                    return date('d-m-Y',$data->trans_date);
                }
            ],
            [
                'attribute'=>'customer_id',
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'value' => function($data){
                  return \backend\models\Customer::findFullname($data->customer_id);
                }
            ],
            [
                'attribute'=>'sale_type_id',
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'value' => function($data){
                   return \backend\helpers\SaleType::getTypeById($data->sale_type_id);
                }
            ],
            //'payment_type_id',
            //'discount_per',
            //'discount_amount',
            //'sale_total',
            //'sale_total_text',
            //'status',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',

            [
                'attribute'=>'status',
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'format' => 'html',
                'value'=>function($data){
                       if($data->status === 1)
                       {
                         return '<div class="label label-success">เปิดการขาย</div>';
                       }else if($data->status === 2){
                           return '<div class="label label-primary">ยืนยันการขาย</div>';}
                       else{
                           return'<div class="label label-default">ปิดการขาย</div>';
                       }
                }
            ],
            [

                'header' => '',
                'headerOptions' => ['style' => 'text-align:center;','class' => 'activity-view-link',],
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'text-align: right'],
                'template' => '{confirmsale}{printbill}{update}{delete}',
                'buttons' => [
                    'confirmsale' => function($url, $data, $index) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'ยืนยันการขาย'),
                            'aria-label' => Yii::t('yii', 'ยืนยันการขาย'),
                            //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            //'data-method' => 'post',
                            //'data-pjax' => '0',
                            'data-val'=>$data->id,
                            'data-url'=>$url,
                            'onclick'=>'confirmsale($(this));'
                        ]);
                        return Yii::$app->user->can('sale/confirmsale')? Html::a('<span class="glyphicon glyphicon-flash btn btn-default"></span>', 'javascript:void(0)', $options):'';
                     },
                    'printbill' => function($url, $data, $index) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'พิมพ์'),
                            'aria-label' => Yii::t('yii', 'พิมพ์'),
                            //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            //'data-method' => 'post',
                            //'data-pjax' => '0',
                            'data-val'=>$data->id,
                            'data-url'=>$url,
                            'onclick'=>'printbill($(this));'
                        ]);
                        return Html::a('<span class="glyphicon glyphicon-print btn btn-default"></span>', 'javascript:void(0)', $options);
                    },
                    'update' => function($url, $data, $index) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'id'=>'modaledit',
                        ]);
                        return  Html::a(
                            '<span class="glyphicon glyphicon-pencil btn btn-default"></span>', $url, [
                            'id' => 'activity-view-link',
                            //'data-toggle' => 'modal',
                            // 'data-target' => '#modal',
                            'data-id' => $index,
                            'data-pjax' => '0',
                            // 'style'=>['float'=>'rigth'],
                        ]);
                    },
                    'delete' => function($url, $data, $index) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            //'data-method' => 'post',
                            //'data-pjax' => '0',
                            'data-url'=>$url,
                            'onclick'=>'recDelete($(this));'
                        ]);
                        return $data->status <=1?Html::a('<span class="glyphicon glyphicon-trash btn btn-default"></span>', 'javascript:void(0)', $options):'';
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
    <div id="billxModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-print"></i> พิมพ์ใบเสร็จ <small id="items"> </small></h4>
                </div>
                <div class="modal-body">
                    <form id="form-modal-bill" action="<?=Url::to(['sale/printbill'],true)?>" method="post" target="_blank">
                        <br>
                        <input type="hidden" name="id" value="" class="sale_line_id">
                        <div class="row">
                            <div class="col-lg-12">
                                ขนาดกระดาษที่ต้องการ
                                <select name="paper_size" id="paper-size">
                                    <option value="1">A4</option>
                                    <option value="2">A5</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-print-bill">พิมพ์</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                </div>
            </div>

        </div>
    </div>
<?php
$this->registerJsFile( '@web/js/sweetalert.min.js',['depends' => [\yii\web\JqueryAsset::className()]],static::POS_END);
$this->registerCssFile( '@web/css/sweetalert.css');
//$url_to_delete =  Url::to(['product/bulkdelete'],true);
$url_to_print = Url::to(['sale/printbill'],true);
$this->registerJs('
    $(function(){
        $("#perpage").change(function(){
            $("#form-perpage").submit();
        });
        
       
        $(".btn-print-bill").click(function(){
            $("#form-modal-bill").submit();
            $("#billxModal").modal("hide");
      //      var ids = $(".sale_line_id").val();
//            if(ids !=""){
//            alert(ids);
//               $.ajax({
//                  "type":"post",
//                  "dataType":"html",
//                  "url":"'.$url_to_print.'",
//                  "data": {"id":ids},
//                  "success": function(data){
//                     alert(data);
//                   
//                  }
//               });
//            }
        });
        
    });
   function confirmsale(e){
      var saleid = e.attr("data-val");
       var url = e.attr("data-url");
        swal({
              title: "ต้องการยืนยันการขายใช่หรือไม่",
              text: "",
              type: "success",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true
            }, function () {
            //  e.attr("href",url); 
            //  e.trigger("click");     
              
              $.ajax({
                "type":"Post",
                "dataType":"html",
                "url": url,
                "async": false,
                "data": {"saleid": saleid},
                "success": function(data){
                  
                }
              });   
        });
   }
   function recDelete(e){
        //e.preventDefault();
        var url = e.attr("data-url");
        swal({
              title: "ต้องการลบรายการนี้ใช่หรือไม่",
              text: "",
              type: "error",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true
            }, function () {
              e.attr("href",url); 
              e.trigger("click");        
        });
    }
    function printbill(e){
     var ids = e.parents("tr").data("key");
     $("#billxModal").modal("show").find(".sale_line_id").val(ids);
    }

    ',static::POS_END);
?>