<?php

/* @var $this yii\web\View */
use backend\themes\klolofil\assets\KlolofilAsset;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Json;
use backend\assets\HighchartAsset;
use yii\grid\GridView;

//HighchartAsset::register($this);

$this->title = 'Thefirst';
KlolofilAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@klolofil/dist');

$dateval = date('d-m-Y').' ถึง '.date('d-m-Y');
//if($from_date !='' && $to_date != ''){
//    $dateval = $from_date.' ถึง '.$to_date;
//}

$searchModel = new \backend\models\LoanpaymentSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider->setSort(['defaultOrder'=>['created_at'=>SORT_DESC]]);



$this->registerCss('
     body{
                font-family: "Cloud-Light";
                font-size: 16px;
            }
');
$js =<<<JS
  $(function() {
    $(".date_select").change(function() {
      $("form#form_date").submit();
    })
    
//   var chart = $("#container-chart").highcharts({
//        chart: {
//        type: 'column'
//        },
//        title: {
//            text: 'กราฟแสดงจำนวนผลิตสินค้า'
//        },
//        xAxis: {
//       // categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
//        categories: ,
//        title: {
//            text: null
//        }
//        },
//        yAxis: {
//            min: 0,
//            title: {
//                text: 'จำนวน',
//                align: 'high'
//            },
//            labels: {
//                overflow: 'justify'
//            }
//        },
//        tooltip: {
//            valueSuffix: ' millions'
//        },
//        plotOptions: {
//            bar: {
//                dataLabels: {
//                    enabled: true
//                }
//            }
//        },
//        legend: {
//            layout: 'vertical',
//            align: 'right',
//            verticalAlign: 'top',
//            x: -40,
//            y: 80,
//            floating: true,
//            borderWidth: 1,
//            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
//            shadow: true
//        },
//        credits: {
//            enabled: false
//        },
//        series: data
//      
//        // series: [{
//        //     name: 'Year 1800',
//        //     data: [107, 31, 635, 203, 2]
//        // }, {
//        //     name: 'Year 1900',
//        //     data: [133, 156, 947, 408, 6]
//        // }, {
//        //     name: 'Year 2000',
//        //     data: [814, 841, 3714, 727, 31]
//        // }, {
//        //     name: 'Year 2016',
//        //     data: [1216, 1001, 4436, 738, 40]
//        // }]
//   });
    
  })
JS;

$this->registerJs($js,static::POS_END);

?>
<!-- WRAPPER -->

<!-- MAIN CONTENT -->

<!-- OVERVIEW -->
<div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-dashboard"></i> ภาพรวมระบบ</h3>
        <!--                        <p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p>-->
        <p class="panel-subtitle">เลือกช่วงข้อมูลที่ต้องการดูรายละเอียด</p>
        <div class="row">
            <div class="col-lg-5">
                <form id="form_date" action="<?=Url::to(['site/index'],true)?>">
                    <?php
                    echo DateRangePicker::widget([
                        'name'=>'date_select',
                        'value' => $dateval,
                        'options' => ['class'=>'date_select'],
                        'presetDropdown' => true,
                        'hideInput' => true,
                        'convertFormat' => true,
                        'pluginOptions' => [
                            'locale'=>['format'=>'d-m-Y','separator'=>' ถึง ']
                        ]
                    ]);
                    ?>
                </form>
            </div>
        </div>

    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-users"></i></span>
                    <p>
                        <span class="number"><?=$cust_count?></span>
                        <span class="title">จำนวนลูกค้า</span>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-cubes"></i></span>
                    <p>
                        <span class="number"><?=number_format($product_count,0)?></span>
                        <span class="title">จำนวนสินค้า</span>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-clock-o"></i></span>
                    <p>
                        <span class="number"><?=number_format($due_count,0)?></span>
                        <span class="title">ลูกค้าถึงรอบชำระเดือนนี้</span>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-exclamation-triangle"></i></span>
                    <p>
                        <span class="number"><?=number_format($over_due_count,0)?></span>
                        <span class="title">ลูกค้าที่เลยกำหนดชำระ</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <?php
                $month = ['Jan', 'Feb', 'Mar', 'Apl', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $plan = ["ยอดขาย"];
                //$po = [1500,1590];
                echo Highcharts::widget([
                    'options' => [
                        'class'=>'compare_chart',
                        'title' => ['text' => ''],
                        'xAxis' => [
                            'categories' => $month
                        ],
                        'yAxis' => [
                            'title' => ['text' => 'จำนวนเ']
                        ],
                        'series' => [
                            ['name' => $plan[0], 'data' => [10780,20000,45760,35900,40880,68900,56500,30892,45990,20540,66000,125090]],


                        ],
                        'credits' => ['enabled' => true],
                        'chart' => [
                            'type' => 'line',
                        ],
                    ]
                ]);
                ?>

            </div>
            <div class="col-md-3">
                <div class="weekly-summary text-right">
                    <span class="number"><?=number_format(0)?></span>
                    <!--                                    <span class="percentage"><i class="fa fa-caret-up text-success"></i> 12%</span>-->
                    <span class="info-label">ยอดขายรวม</span>
                </div>
                <div class="weekly-summary text-right">
                    <span class="number"><?=number_format(0)?></span>
                    <!--                                    <span class="percentage"><i class="fa fa-caret-up text-success"></i> 23%</span>-->
                    <span class="info-label">ยอดชำระล่าสุด</span>
                </div>
                <div class="weekly-summary text-right">
                    <span class="number">65,938</span>
                    <!--                                    <span class="percentage"><i class="fa fa-caret-down text-danger"></i> 8%</span>-->
                    <span class="info-label">ยอดขายที่ต้องได้</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END OVERVIEW -->
<div class="row">
    <div class="col-md-6">
        <!-- RECENT PURCHASES -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">ประวัติการชำระล่าสุด</h3>
                <div class="right">
                    <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                    <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            //  'filterModel' => $searchModel,
                            'columns' => [
                                //  ['class' => 'yii\grid\SerialColumn'],

                                //  'id',
                                [
                                    'attribute' => 'load_id',
                                    'value' => function($data){
                                        return \backend\models\Loan::findNumber($data->loan_id);
                                    }
                                ] ,
                                [
                                    'label' => 'ชื่อลูกค้า',
                                    'value' => function($data){
                                        return \backend\models\Loan::findLoanCust($data->loan_id);
                                    }
                                ] ,
                                [
                                    'attribute' => 'amount',
                                    'label' => 'จำนวนเงิน',
                                    'value' => function($data){
                                        return number_format($data->amount,0);
                                    }
                                ] ,
                                [
                                    'attribute' => 'periodof',
                                    'value' => function($data){
                                       // return date('d-m-Y',$data->payment_date);
                                        return $data->periodof;
                                    }
                                ] ,
                                [
                                    'attribute' => 'payment_date',
                                    'value' => function($data){
                                        return date('d-m-Y',$data->payment_date);
                                    }
                                ] ,

                                //'status',
                                //'created_at',
                                //'updated_at',
                                //'created_by',
                                //'updated_by',

                                //['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>
                    </div>
                </div>

            </div>
            <div class="panel-footer">
                <div class="row">
                    <!--                                    <div class="col-md-6"><span class="panel-note"><i class="fa fa-clock-o"></i></span></div>-->
                    <div class="col-md-6 text-left"><a href="#" class="btn btn-primary">ดูรายการทั้งหมด</a></div>
                </div>
            </div>
        </div>
        <!-- END RECENT PURCHASES -->
    </div>

</div>


<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->
<div class="clearfix"></div>
<footer>
    <div class="container-fluid">
        <p class="copyright">&copy; 2018 <a href="https://www.themeineed.com" target="_blank">Theme I Need</a>. All Rights Reserved.</p>
    </div>
</footer>


<!-- END WRAPPER -->