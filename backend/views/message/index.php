<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <div class="main-content">
        <div class="container-fluid">


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
                      <h4> <i class="fa fa-comment-o"></i> <?=$this->title?><small></small></h4>
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
        'layout'=>'{items}{summary}{pager}',
        'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
        'tableOptions' => ['class' => 'table table-hover'],
        'rowOptions' => function($model){
            if($model->status == 1){
                return ['class'=>'success'];
            }else{
                return ['class'=>'danger'];
            }
        },
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'vertical-align: middle','text-align:center'],
            ],

          //  'id',
          //  'message_type',
            [
                'attribute'=>'message_type',
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'value' => function($data){
                    return \backend\helpers\MessageType::getTypeById($data->message_type);
                }
            ],
            [
                'attribute'=>'title',
                'contentOptions' => ['style' => 'vertical-align: middle'],
            ],
//            [
//                'attribute'=>'detail',
//                'contentOptions' => ['style' => 'vertical-align: middle'],
//            ],
           // 'status',
            [
                'attribute'=>'status',
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'format' => 'html',
                'value'=>function($data){
                    return $data->status === 1 ? '<div class="label label-danger">ยังไม่อ่าน</div>':'<div class="label label-success">อ่านแล้ว</div>';
                }
            ],
            [
                'attribute'=>'created_by',
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'value' => function($data){
                    return \backend\models\User::findName($data->created_by);
                }
            ],
            [
                'attribute'=>'created_at',
                'contentOptions' => ['style' => 'vertical-align: middle'],
                'value' => function($data){
                    return date('d-m-Y',$data->created_at);
                }
            ],
            //'updated_at',
          //  'created_by',
            //'updated_by',

            [

                'header' => '',
                'headerOptions' => ['style' => 'width: 160px;text-align:center;','class' => 'activity-view-link',],
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'text-align: center'],
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
                        return $data->status == 100? Html::a(
                            '<span class="glyphicon glyphicon-pencil btn btn-default"></span>', $url, [
                            'id' => 'activity-view-link',
                            //'data-toggle' => 'modal',
                            // 'data-target' => '#modal',
                            'data-id' => $index,
                            'data-pjax' => '0',
                            // 'style'=>['float'=>'rigth'],
                        ]):'';
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
                        return Html::a('<span class="glyphicon glyphicon-trash btn btn-default"></span>', 'javascript:void(0)', $options);
                    }
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

