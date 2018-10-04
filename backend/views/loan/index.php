<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use lavrentiev\widgets\toastr\Notification;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\LoanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'สินเชื่อ/ผ่อน');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-index">

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
            <div class="btn-group"><?= Html::a(Yii::t('app', '<i class="fa fa-plus"></i> สร้าง'), ['create'], ['class' => 'btn btn-success']) ?></div>
            <h4 class="pull-right"><?=$this->title?> <i class="fa fa-institution"></i><small></small></h4>
        </div>
        <div class="panel-body">
            <div class="x_panel">

                <div class="x_content">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="form-inline">
                                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="pull-right">
                                <form id="form-perpage" class="form-inline" action="<?=Url::to(['location/index'],true)?>" method="post">
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
       // 'filterModel' => $searchModel,
        'emptyCell'=>'-',
        'layout'=>'{items}{summary}{pager}',
        'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
        'showOnEmpty'=>false,
        'tableOptions' => ['class' => 'table table-hover'],
        'emptyText' => '<div style="color: red;align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','contentOptions' => ['style' => 'vertical-align: middle']],

            //'id',
            [
                'attribute'=>'loan_no',
                'headerOptions' => ['style' => 'text-align: left'],
                'contentOptions' => ['style' => 'vertical-align: middle'],
            ],
            [
                'attribute'=>'loan_date',
                'headerOptions' => ['style' => 'text-align: left'],
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'value' => function($data){
                    return date('d-m-Y',$data->loan_date);
                }
            ],
            [
                'attribute'=>'personal_id',
                'headerOptions' => ['style' => 'text-align: left'],
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'value' => function($data){
                    return \backend\models\Customer::findFullName($data->personal_id);
                }
            ],
            [
                'attribute'=>'first_pay_date',
                'headerOptions' => ['style' => 'text-align: left'],
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'value' => function($data){
                    return date('d-m-Y',$data->first_pay_date);
                }
            ],
            [
                'attribute'=>'next_pay_date',
                'headerOptions' => ['style' => 'text-align: left'],
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'value' => function($data){
                    return date('d-m-Y',$data->next_pay_date);
                }
            ],
            [
                'attribute'=>'append_date',
                'headerOptions' => ['style' => 'text-align: left'],
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'value' => function($data){
                    return $data->append_date!= null? date('d-m-Y',$data->append_date):'';
                }
            ],
            [
                'attribute'=>'sale_id',
                'headerOptions' => ['style' => 'text-align: left'],
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'value' => function($data){
                        return \backend\models\Sale::findCode($data->sale_id);
                }
            ],

            //'period_type',
            //'factor',
            //'period',
            //'payment_per',
            //'first_pay',
            //'first_pay_date',
            //'next_pay_date',
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
                    if($data->status <=1){
                        return '<div class="label label-success">รอชำระเงิน</div>';
                    }else if($data->status == 2){
                        return '<div class="label label-default">ชำระเรียบร้อย</div>';
                    }else if($data->status ==3){
                        return '<div class="label label-warning">เลื่อนชำระ</div>';
                    }

                }
            ],
            [

                'header' => '',
                'headerOptions' => ['style' => 'text-align:center;','class' => 'activity-view-link',],
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'text-align: center'],
                'template' => '{view}{payment}{postpone}{delete}',
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
                    'payment' => function($url, $data, $index) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Payment'),
                            'aria-label' => Yii::t('yii', 'Payment'),
                            'data-pjax' => '0',
                            'data-key' => $data->id,
                        ]);
                        return $data->status !=2? Html::a(
                            '<span class="glyphicon glyphicon-qrcode btn btn-default btn-pay"></span>', 'javascript:void(0)', $options):'';
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
                    'postpone' => function($url, $data, $index) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Postpone'),
                            'aria-label' => Yii::t('yii', 'Postpone'),
                            //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            //'data-method' => 'post',
                            //'data-pjax' => '0',
                            'onclick'=>'postpone($(this));'
                        ]);
                        return $data->status !=2?Html::a('<span class="glyphicon glyphicon-time btn btn-default"></span>', 'javascript:void(0)', $options):'';
                    },
                    'delete' => function($url, $data, $index) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            //'data-method' => 'post',
                            //'data-pjax' => '0',
                            'onclick'=>'recDelete($(this));'
                        ]);
                        return $data->status <=1?Html::a('<span class="glyphicon glyphicon-trash btn btn-default"></span>', 'javascript:void(0)', $options):'';
                    }
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
                </div>
                    <div id="payModal" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-md">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><i class="fa fa-money text-primary"></i> ชำระเงินสินเชื่อเลขที่ <span class="loan_no"></span> </h4>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" class="loan-id" value="">
                                    <input type="hidden" class="fine-per-day" value="">
                                    <input type="hidden" class="pay-time-of" value="">
                                    <div class="row">
                                       <div class="col-lg-12">
                                           <table style="border: none">
                                               <tr>
                                                   <td style="padding: 5px 5px 5px 5px"><b>ชำระงวดที่</b></td>
                                                   <td><span class="pay-time"></span></td>
                                               </tr>
                                               <tr>
                                                   <td style="padding: 5px 5px 5px 5px"><b>ชำระทุกวันที่</b></td>
                                                   <td><span class="pay-ever-day"></span></td>
                                               </tr>
                                               <tr>
                                                   <td style="padding: 5px 5px 5px 5px"><b>กำหนดชำระ</b></td>
                                                   <td><span class="must-pay-day"></span></td>
                                               </tr>
                                               <tr>
                                                   <td style="padding: 5px 5px 5px 5px"><b>จำนวนที่ต้องชำระ/งวด</b></td>
                                                   <td><span class="pay-per"></span></td>
                                               </tr>
                                               <tr>
                                                   <td style="padding: 5px 5px 5px 5px"><b>จำนวนชำระ</b></td>
                                                   <td style="padding: 5px 5px 5px 5px"><input type="text" class="form-control pay-amount" value="0" ></td>
                                               </tr>
                                               <tr>
                                                   <td style="padding: 5px 5px 5px 5px"><b>ค่าปรับ</b></td>
                                                   <td style="padding: 5px 5px 5px 5px"><input type="text" class="form-control fine-amount" readonly value="0" ></td>
                                               </tr>
                                               <tr>
                                                   <td style="padding: 5px 5px 5px 5px"><b>บันทึก</b>

                                                   </td>
                                                   <td style="padding: 5px 5px 5px 5px">
                                                       <textarea name="" id="pay-note" cols="30" rows="3"></textarea>
                                                   </td>

                                               </tr>
                                           </table>
                                       </div>
                                   </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success btn-pay-ok" data-dismiss="modal">ตกลง</button>
                                </div>
                            </div>
                        </div>
                    </div>
    <div id="postponeModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-money text-primary"></i> เลื่อนการชำระเงิน <span class="loan_no"></span> </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" name="loan_append_id" class="loan_append_id" value="">
                            <p><b>เลื่อนชำระวันที่</b></p>
                            <?php echo \kartik\date\DatePicker::widget([
                                'name'=>'postpone_date',
                                'name'=>'postpone_date',
                                'value' => date('d-m-Y'),
                                'options' => [
                                    'class'=>'postpone_date',
                                ],
                                'pluginOptions' => [
                                        'format'=>'dd-mm-yyyy'
                                ]
                              ]);?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-append-ok" data-dismiss="modal">ตกลง</button>
                </div>
            </div>
        </div>
    </div>
<?php
$url_to_payment = Url::to(['loan/payment'],true);
$url_to_paymentsubmit = Url::to(['loan/paymentsubmit'],true);
$url_to_postpone = Url::to(['loan/postpone'],true);
$js =<<<JS
 $(function() {
    $(".btn-pay").click(function() {
        $("#payModal").modal("show");
        var loan_id = $(this).parents("tr").data("key");
        
        $.ajax({
           'type': 'post',
           'dataType': 'json',
           'url': "$url_to_payment",
           'async': false,
           'data': {'loanid': loan_id},
           'success': function(data){
               if(data.length > 0){
                   $("#payModal").find(".loan-id").val(loan_id);
                    $("#payModal").find(".loan_no").text(data[0]['loan_no']);
                   $("#payModal").find(".must-pay-day").text(data[0]['must_pay_day']);
                   $("#payModal").find(".pay-time").text(data[0]['pay_time']);
                   $("#payModal").find(".pay-time-of").val(data[0]['pay_time']);
                   $("#payModal").find(".pay-ever-day").text(data[0]['pay_ever_day']);
                   $("#payModal").find(".pay-per").text(parseFloat(data[0]['pay_per']).toFixed(0));
                   $("#payModal").find(".pay-amount").val(parseFloat(data[0]['pay_per']).toFixed(0));
                   $("#payModal").find(".fine-per-day").val(data[0]['fine_per_day']);
                   
                   
                    var today = new Date();
                    var dd = today.getDate();
                    var mm = today.getMonth()+1; //January is 0!

                    var yyyy = today.getFullYear();
                    if(dd<10){
                        dd='0'+dd;
                    } 
                    if(mm<10){
                        mm='0'+mm;
                    } 
                    var todays = dd+'-'+mm+'-'+yyyy;
                   // alert(today);
                   
                   // if(today > data[0]['must_pay_day']){
                   //                   //     alert("over");
                   //                   // }
                   
                    var arrDate = data[0]['must_pay_day'].split("-");
                    var arrDate2 = todays.split("-");
           // var today = new Date(todays);
           var useToday = new Date(arrDate2[2], arrDate2[1] - 1, arrDate2[0]);
           var useDate = new Date(arrDate[2], arrDate[1] - 1, arrDate[0]);
            alert(useToday);
           alert(useDate);
            if (useToday > useDate) {
               $(".fine-per-day").val(data[0]['fine_per_day']);
            } else{
               $(".fine-per-day").val(0);
            } 
                   
               }
           }
        });
    });
    $(".btn-pay-ok").click(function() {
       var loanid = $(".loan-id").val();
       var payamt = $(".pay-amount").val();
       var fine = $(".fine-amount").val();
       var note = $("#pay-note").val();
       var paytimeof = $(".pay-time-of").val();
     //  alert(paytimeof);
       $.ajax({
           'type': 'post',
           'dataType': 'json',
           'url': "$url_to_paymentsubmit",
           'async': false,
           'data': {'loanid': loanid,'payamt': payamt,'find':fine,'note':note,'peroidof':paytimeof},
           'success': function(data){
              alert(data);
           }
        });
       
    });
    $(".btn-append-ok").click(function() {
       var loanid = $(".loan_append_id").val();
       var postpone_date = $(".postpone_date").val();
       
       //alert(loanid);return;
       $.ajax({
           'type': 'post',
           'dataType': 'json',
           'url': "$url_to_postpone",
           'async': false,
           'data': {'loanid': loanid,'postpone_date': postpone_date},
           'success': function(data){
              alert(data);
           }
        });
       
    });
   
 });

function postpone(e) {
    var id = e.parents("tr").data("key");
  $("#postponeModal").modal("show").find(".loan_append_id").val(id) ;
}

JS;

$this->registerJs($js,static::POS_END);

?>