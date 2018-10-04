<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\editable\Editable;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\StockbalanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'สต๊อกสินค้า');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-headline">
    <div class="panel-heading">
       <h2 class=""><i class="fa fa-cubes"></i> <?=$this->title?> <small></small></h2>
    </div>
    <div class="panel-body">
        <?php Pjax::begin()?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

          //  'id',
            [
             'attribute' => 'product_id',
             'format' => 'html',
             'value' => function($data){
                return '<a href="index.php?r=product/view&id=">'.\backend\models\Product::findProductcode($data->product_id)."</a>";
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
                'class'=>'kartik\grid\EditableColumn',
                'attribute'=>'qty',
                'editableOptions'=>[
                    'header'=>'จำนวน',
                    'inputType'=>\kartik\editable\Editable::INPUT_SPIN,
                    'options'=>['pluginOptions'=>['min'=>0, 'max'=>5000]]
                ],
                'hAlign'=>'left',
                'vAlign'=>'middle',
                'width'=>'250px',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            //'status',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
</div>
