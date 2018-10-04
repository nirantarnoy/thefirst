<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Message */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-view">
    <div class="panel panel-headline">
        <div class="panel-heading">
<!--            <h2> <i class="fa fa-commenting-o text-success"></i> --><?php //echo $this->title?><!--<small></small></h2>-->
        </div>
        <div class="panel-body">
<?php //echo DetailView::widget([
//                'model' => $model,
//                'attributes' => [
//                  //  'id',
//                    [
//                     'attribute'=>'message_type',
//                     'value'=>function($data){
//                        return \backend\helpers\MessageType::getTypeById($data->message_type);
//                     }
//                    ],
//                    'title',
//                    'detail',
//                  //  'status',
//                    [
//                        'attribute'=>'created_at',
//                        'value'=>function($data){
//                            return date('d-m-Y',$data->created_at);
//                        }
//                    ],
//                  //  'updated_at',
//                    [
//                        'attribute'=>'created_by',
//                        'value'=>function($data){
//                            return \backend\models\User::findName($data->created_by);
//                        }
//                    ],
//                  //  'updated_by',
//                ],
//            ]) ?>
            <div class="media">
                <div class="media-left media-top">
                    <h1><i class="fa fa-commenting-o text-warning"></i></h1>
                </div>
                <div class="media-body">
                    <h2 class="media-heading" style="color: #00b488"><?=$model->title?> <small> #<?=\backend\helpers\MessageType::getTypeById($model->message_type)?></small></h2>
                    <?=$model->detail?>
                    <br><br>
                    <i class="fa fa-user"></i> <?=\backend\models\User::findName($model->created_by)?>
                    <i class="fa fa-calendar"> </i> <?=date('d-m-Y H:i:s',$model->created_at)?>
                    <?php if($model->status ==1): ?>
                        <label for="" class="label label-success">ยังไม่อ่าน</label>
                    <?php else:?>
                        <label for="" class="label label-danger">อ่านแล้ว</label>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
