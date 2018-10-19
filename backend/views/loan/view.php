<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model backend\models\Loan */

$this->title = $model->loan_no;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'สินเชื่อ/ผ่อน'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss('
  .borderless td, .borderless th {
    border: none;
    padding: 5px;15px;5px;35px;
  }
');
?>
<div class="loan-view">


    <div class="panel panel-headlin">
        <div class="panel-heading">
            <h3><i class="fa fa-list-ol"></i> รายละเอียดรายการผ่อนเลขที่ <small><?= $model->loan_no?></small></h3>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-4">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options'=>['class'=>'borderless'],
                        'attributes' => [
                            // 'id',
                            'loan_no',
                            [
                                'attribute'=>'loan_date',
                                'value'=>function($data){
                                    return date('d-m-Y',$data->loan_date);
                                }
                            ],
                            'period',
                            [
                                'attribute'=>'loan_percent',
                                'label' => 'ดอกเบี้ย',
                                'value'=>function($data){
                                    return number_format($data->loan_percent,0)." %";
                                }
                            ],
                            [
                                'attribute'=>'payment_per',
                                'value'=>function($data){
                                    return number_format($data->payment_per,0);
                                }
                            ],
                            [
                                'attribute'=>'first_pay_date',
                                'value'=>function($data){
                                    return date('d-m-Y',$data->first_pay_date);
                                }
                            ],
                            [
                                'attribute'=>'end_pay_date',
                                'label'=>'วันที่ครบชำระ',
                                'value'=>function($data){
                                    return date('d-m-Y',$data->end_pay_date);
                                }
                            ],
                            [
                                'attribute'=>'fee_rate',
                                'label' => 'ค่าปรับล่าช้า/วัน',
                                'value'=>function($data){
                                    return number_format($data->fee_rate,0);
                                }
                            ],
                            [
                                'attribute'=>'status',
                                'format' => 'html',
                                'value'=>function($data){
                                    return $data->status === 1 ?'<div class="label label-success">รอการชำระเงิน</div>':'<div class="label label-default">ชำระเงินครบแล้ว</div>';
                                }
                            ],

                        ],

                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options'=>['class'=>'borderless'],
                        'attributes' => [
                            // 'id',
                            [
                                'attribute'=>'sale_id',
                                'label'=>'เลขที่ขายอ้างอิง',
                                'value'=>function($data){
                                    return \backend\models\Sale::findCode($data->sale_id);
                                }
                            ],
                            'period',
                            [
                                'attribute'=>'personal_id',
                                'label' => 'รหัสลูกค้า',
                                'value'=>function($data){
                                    return \backend\models\Customer::findCode($data->personal_id);
                                }
                            ],
                            [
                                'attribute'=>'personal_id',
                                'label' => 'ชื่อลูกค้า',
                                'value'=>function($data){
                                    return \backend\models\Customer::findName($data->personal_id);
                                }
                            ],


                        ],

                    ]) ?>
                </div>



        </div>
    </div>
</div>

    <div class="panel panel-headlin">
        <div class="panel-heading">
            <h3><i class="fa fa-clock-o text-danger"></i> ประวัติการชำระ</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-4">
                  <p><b>วันที่ชำระครั้งหน้า <i class="fa fa-calendar"></i> <span class="text-success"><?=date('d-m-Y',$next_pay)?></span></b></p>
                </div>
                <div class="col-lg-4">
                    <p><b>วันที่ชำระล่าสุด <i class="fa fa-calendar"></i> <span class="text-success"><?=date('d-m-Y',$last_pay)?></span></b></p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                      //  'filterModel' => $searchModel,
                        'emptyCell'=>'-',
                        'layout'=>'{items}{summary}{pager}',
                        'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
                        'showOnEmpty'=>false,
                      //  'tableOptions' => ['class' => 'table table-hover'],
                        //'emptyText' => '<div style="color: red;align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn',
                                'headerOptions' => ['style'=>'text-align: center'],
                                'contentOptions' => ['style' => 'vertical-align: middle;text-align: center'],
                            ],

                            // 'id',
                            [
                                'attribute'=>'payment_date',
                                'contentOptions' => ['style' => 'vertical-align: middle'],
                                'value' => function($data){
                                    return date('d-m-Y H:i:s',$data->payment_date);
                                }
                            ],
                            [
                                'attribute'=>'periodof',
                                'label' => 'งวดที่',
                                'headerOptions' => ['style'=>'text-align: center'],
                                'contentOptions' => ['style' => 'vertical-align: middle;text-align: center'],
                            ],
                            [
                                'attribute'=>'amount',
                                'headerOptions' => ['style'=>'text-align: right'],
                                'contentOptions' => ['style' => 'vertical-align: middle;text-align: right'],
                                'value'=>function($data){
                                    return number_format($data->amount,0);
                                }
                            ],
                            [
                                'attribute'=>'fine',
                                'label' => 'ค่าปรับ',
                                'headerOptions' => ['style'=>'text-align: right'],
                                'contentOptions' => ['style' => 'vertical-align: middle;text-align: right'],
                                'value'=>function($data){
                                    return number_format($data->fine,0);
                                }
                            ],

                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>


</div>
