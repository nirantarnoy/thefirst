<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Claim */

$this->title = $model->claim_no;
$this->params['breadcrumbs'][] = ['label' => 'เคลมสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="claim-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'claim_no',
            [
                    'attribute'=>'trans_date',
                    'value'=>function($data){
                        return date('d-m-Y',$data->trans_date);
                    }
            ],
            'sale_no',
            [
                'attribute' => 'status',
                'format'=>'html',
                'value'=>function($data){
                    if($data->status === 1)
                    {
                        return '<div class="label label-success">รอยืนยัน</div>';
                    }else if($data->status === 2){
                        return '<div class="label label-primary">เคลมสินค้าสมบูรณ์</div>';
                    }
                }
            ],
            [
                'attribute'=>'created_at',
                'value'=>function($data){
                    return date('d-m-Y',$data->created_at);
                }
            ],

        ],
    ]) ?>

</div>
