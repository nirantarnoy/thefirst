<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use kartik\daterange\DateRangePicker;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->registerCss('
  .borderless td, .borderless th {
    border: none;
    padding: 5px;15px;5px;35px;
  }
');

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'สินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">
<div class="row">
      <div class="col-lg-12">
            <div class="btn-group">
                 <?= Html::a(Yii::t('app', '<i class="fa fa-pencil"></i> แก้ไข'), ['update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a(Yii::t('app', '<i class="fa fa-trash"></i> ลบ'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-default',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
<!--        <div class="btn btn-default"><i class="fa fa-barcode"></i> พิมพ์บาร์โค้ด</div>-->
            </div>
          <div class="pull-right">
              <a href="<?=Url::to(['product/index'],true)?>"><div class="btn btn-default">กลับ <i class="fa fa-arrow-right"></i> </div></a>
          </div>
            
      </div>
     </div>
<div class="row" style="margin-top: 5px;">
  <div class="col-lg-12">
      <div class="panel panel-headline">
          <div class="panel-heading">
            <h3><i class="fa fa-cube"></i> รายละเอียดสินค้า <small><?= $model->name?></small></h3>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
           
           <div class="row">
               <div class="col-lg-4">
                   <?= DetailView::widget([
                        'model' => $model,
                        'options'=>['class'=>'borderless'],
                        'attributes' => [
                         //   'id',
                            'product_code',
                            'name',
                            'description',
                            'barcode',

                            [
                                          'attribute'=>'unit_id',
                                          'headerOptions' => ['style' => 'text-align: left'],
                                          'contentOptions' => ['style' => 'vertical-align: middle'],
                                          'value'=> function($data){
                                            return \backend\models\Unit::findUnitname($data->unit_id);
                                          }  
                                     ],
                                     [
                                          'attribute'=>'category_id',
                                          'headerOptions' => ['style' => 'text-align: left'],
                                          'contentOptions' => ['style' => 'vertical-align: middle'], 
                                           'value'=> function($data){
                                            return \backend\models\Productcat::findGroupname($data->category_id);
                                          }   
                                      ],
                            
                        ],
                    ]) ?>
                     <!-- <div class="btn btn-default" style="margin-top: 5px;"> ดูตามที่จัดเก็บ</div> -->
               </div>
               <div class="col-lg-4">
                   <?= DetailView::widget([
                        'model' => $model,
                        'options'=>['class'=>'borderless'],
                        'attributes' => [

                            [
                                'attribute'=>'cost',
                                'value'=>function($data){
                                    return $data->cost!=''?number_format($data->cost,0):0;
                                }
                            ],
                            [
                                'attribute'=>'price',
                                'value'=>function($data){
                                    return $data->price!=''?number_format($data->price,0):0;
                                }
                            ],
                            [
                                'attribute'=>'status',
                                'format' => 'html',
                                'value'=>function($data){
                                    return $data->status === 1 ? '<div class="label label-success">Active</div>':'<div class="label label-default">Inactive</div>';
                                }
                            ],
                            [
                                'attribute'=>'created_at',
                                'value'=>function($data){
                                    return date('d-m-Y H:i',$data->created_at);
                                }
                            ],
                            [
                                'attribute'=>'updated_at',
                                'value'=>function($data){
                                    return date('d-m-Y H:i',$data->created_at);
                                }
                            ],
                            [
                                'attribute'=>'created_by',
                                'value'=>function($data){
                                    $name = \backend\models\User::getUserinfo($data->created_by);
                                    return $name!=null?$name->username:'';
                                }
                            ],
                            [
                                'attribute'=>'updated_by',
                                'value'=>function($data){
                                     $name = \backend\models\User::getUserinfo($data->updated_by);
                                    return $name!=null?$name->username:'';
                                }
                            ],
                        ],
                    ]) ?>
               </div>
               <div class="col-lg-4">
                <div class="row">

                        <div class="col-md-6 tile">
                          <span><b>จำนวนสินค้า</b></span>
                          <h2><?=$model->all_qty!=""?number_format($model->all_qty):0?></h2>
                          <span class="sparkline22 graph" style="height: 160px;">
                                <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                        </div>
                </div>
                      
<!--                    <i class="fa fa-warning"></i> <small class="text-danger"> คลิกดูรายการจำนวนสินค้าที่ตัวเลขจำนวน</small> -->
               </div>
           </div>

            <div class="row">
                <div class="col-lg-12">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        //  'filterModel' => $searchModel,
                        'columns' => [
                            //  ['class' => 'yii\grid\SerialColumn'],

                            //  'id',
                            [
                                'attribute' => 'product_id',
                                'value' => function($data){
                                    return \backend\models\Product::findProductcode($data->product_id);
                                }
                            ] ,
                            [
                                'attribute' => 'product_id',
                                'label' => 'ชื่อสินค้า',
                                'value' => function($data){
                                    return \backend\models\Product::findName($data->product_id);
                                }
                            ] ,
                            [
                                'attribute' => 'warehouse_id',
                                'value' => function($data){
                                    return \backend\models\Warehouse::findWarehousename($data->warehouse_id);
                                }
                            ] ,
                            [
                                'attribute' => 'loc_id',
                                'value' => function($data){
                                    return \backend\models\Location::findName($data->loc_id);
                                }
                            ] ,
                            [
                                'attribute' => 'qty',
                                'value' => function($data){
                                    return number_format($data->qty,0);
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
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>เลขที่รายการ</th>
                            <th>วันที่</th>
                            <th>ราคา</th>
                            <th>จำนวน</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($stock_price as $value):?>
                            <tr>
                                <td><?=\backend\models\Journal::getJournalinfo($value->journal_line_id)->journal_no?></td>
                                <td><?=date('d-m-Y',$value->created_at);?></td>
                                <td><?=$value->price?></td>
                                <td><?=$value->qty?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>

       </div>
 </div>
</div>
</div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-headlin">
                <div class="panel-heading">
                    <h2><i class="fa fa-asterisk"></i> ประวัติสินค้า เข้า-ออก <small>ล่าสุด</small></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php Pjax::begin(); ?>
                        <div class="col-lg-12">
                            <?= GridView::widget([
                                'dataProvider' => $movementDp,
                                //'filterModel' => $movementSearch,
                                'emptyCell'=>'-',
                                'layout'=>'{summary}{items}{pager}',
                                'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
                                'showOnEmpty'=>true,
                                'tableOptions' => ['class' => 'table table-hover'],
                                'emptyText' => '<div style="color: red;align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn','contentOptions' => ['style' => 'vertical-align: middle;text-align: center;']],
                                    'journal_no',
                                    [
                                        'attribute' => 'product_id',
                                        'contentOptions' => ['style' => 'vertical-align: middle'],
                                        'format'=>'html',
                                        'value' => function($data){
                                            return '<a href="'.Url::to(['product/view','id'=>$data->product_id],true).'">'.\backend\models\Product::findProductcode($data->product_id).'</a>';
                                        }
                                    ],
                                    [
                                        'attribute'=>'trans_type',
                                        'contentOptions' => ['style' => 'vertical-align: middle'],
                                        'value' => function($data){
                                            return \backend\helpers\JournalType::getTypeById($data->trans_type);
                                        }
                                    ],
                                    'reference',

                                    [
                                        'attribute' => 'qty',
                                        'contentOptions' => ['style' => 'vertical-align: middle'],
                                        'value' => function($data){
                                            return number_format($data->qty,0);
                                        }
                                    ],
                                    [
                                        'attribute' => 'stock_direction',
                                        'contentOptions' => ['style' => 'vertical-align: middle'],
                                        'format' => 'html',
                                        'value' => function($data){
                                            return $data->stock_direction==1?"<div class='label label-success'> เข้า </div>":"<div class='label label-danger'> ออก </div>";
                                        }

                                    ] ,

                                    [
                                        'attribute' => 'created_by',
                                        'contentOptions' => ['style' => 'vertical-align: middle'],
                                        'value' => function($data){
                                            return \backend\models\User::getUserinfo($data->created_by)->username;
                                        }
                                    ],
                                    [
                                        'attribute' => 'created_at',
                                        'contentOptions' => ['style' => 'vertical-align: middle'],
                                        'value' =>function($data){
                                            return date('d-m-y h:i:s',$data->created_at);
                                        } ,

                                    ]
                                ],
                            ]); ?>
                        </div>
                        <?php Pjax::end(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>






</div>

<?php $this->registerCss('
   .card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    width: 20%;
    float: left;
    margin: 5px;
    }
    
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }
    .card-container {
        padding: 2px 16px;
    }
');?>
