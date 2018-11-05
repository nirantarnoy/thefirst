<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\themes\klolofil\assets\KlolofilAsset;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

KlolofilAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@klolofil/dist');

$this->registerCss('
     body{
                font-family: "Cloud";
                font-size: 16px;
            }
     .required{
             color: red;
        }
');
$cururl = Yii::$app->controller->id;
//echo $cururl;return;

$this->registerJs('
$(function(){
  //$(".sidebar-scroll").find(".nav").find(".usect").trigger("click");
  var xx = $(".sidebar-scroll").find(".nav").find("'.".".$cururl.'").parent().parent().parent().parent().attr("class");
  //alert(xx);
  if(xx == "has-sub"){
    $(".sidebar-scroll").find(".nav").find("'.".".$cururl.'").parent().parent().parent().parent().find(".collapsed").trigger("click");
  }
  $(".sidebar-scroll").find(".nav").find("'.".".$cururl.'").addClass("active");
});
',static::POS_END);

$last_message = \backend\models\Message::find()->where(['status'=>1])->limit(6)->orderBy(['created_at'=>SORT_DESC])->all();
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="shortcut icon" href="<?=Url::to(['site/index'],true) ?> THEFIRST" type="image/x-icon" />

        <?php $this->head() ?>

    </head>
    <body>
    <div id="wrapper">
    <!-- NAVBAR -->
    <nav id="main-nav" class="navbar navbar-default navbar-fixed-top">
        <div class="brand">
<!--            <a href="index.html"><img src="img/aj.png" alt="Klorofil Logo" class="img-responsive logo"></a>-->
            <a href="<?=Url::to(['site/index'],true) ?>">THE FIRST</a>
        </div>
        <div id="nav-container" class="container-fluid">
            <div class="navbar-btn">
                <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
            </div>
            <form class="navbar-form navbar-left">
                <div class="input-group">
                    <input type="text" value="" class="form-control" placeholder="ค้นหาหน้า dashboard...">
                    <span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
                </div>
            </form>

            <div id="navbar-menu" style="z-index: 5000">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a id="tog-dropdown" href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                            <i class="lnr lnr-alarm"></i>
                            <?php if(count($last_message)>0):?>
                                <span class="badge bg-danger"><?=count($last_message)?></span>
                            <?php endif;?>
                        </a>
                        <?php if(count($last_message)>0):?>
                            <ul class="dropdown-menu notifications">
                                <?php foreach ($last_message as $data):?>
                                    <li><a href="<?=Url::to(['message/view','id'=>$data->id],true)?>" class="notification-item"><span class="dot bg-success"></span><?=$data->title?></a></li>
                                <?php endforeach;?>
                                <?php if(count($last_message)>5):?>
                                    <li><a href="<?=Url::to(['message/index'],true)?>" class="more">ดูข้อความทั้งหมด</a></li>
                                <?php endif;?>
                            </ul>
                        <?php endif;?>
                    </li>
<!--                    <li class="dropdown">-->
<!--                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="lnr lnr-question-circle"></i> <span>Help</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>-->
<!--                        <ul class="dropdown-menu">-->
<!--                            <li><a href="#">Basic Use</a></li>-->
<!--                            <li><a href="#">Working With Data</a></li>-->
<!--                            <li><a href="#">Security</a></li>-->
<!--                            <li><a href="#">Troubleshooting</a></li>-->
<!--                        </ul>-->
<!--                    </li>-->
                    <li id="li-nav" class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><?=\backend\models\User::findName(Yii::$app->user->id);?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>

                        <ul class="dropdown-menu">
                            <li><a href="index.php?r=site/resetpassword"><i class="fa fa-refresh"></i> <span>เปลี่ยนรหัสผ่าน</span></a></li>
                            <li><a href="index.php?r=site/logout"><i class="lnr lnr-exit"></i> <span>ออกจากระบบ</span></a></li>
                        </ul>
                    </li>
                    <!-- <li>
                        <a class="update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR -->
    <!-- LEFT SIDEBAR -->
    <div id="sidebar-nav" class="sidebar">
        <div class="sidebar-scroll">
            <br />
            <nav>
                <ul class="nav">
                    <li><a href="index.php?r=site/index" class="site"><i class="fa fa-dashboard"></i> <span>แดซบอร์ด</span></a></li>
                    <?php if(\Yii::$app->user->can('Manage plant')):?>
                     <li><a href="index.php?r=plant/index" class="plant"><i class="lnr lnr-code"></i> <span>ข้อมูลร้าน</span></a></li>
                    <?php endif;?>
                    <?php if(\Yii::$app->user->can('Manage usergroup')):?>
                        <li class="has-sub">
                            <a href="#subUser" data-toggle="collapse" class="collapsed usect"><i class="fa fa-users"></i> <span>ข้อมูลผู้ใช้</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                            <div id="subUser" class="collapse ">
                                <ul class="nav">
                                    <li><a href="index.php?r=usergroup/index" class="usergroup">กลุ่มผู้ใช้</a></li>
                                    <li><a href="index.php?r=user/index" class="user">ผู้ใช้งาน</a></li>
                                    <li><a href="index.php?r=authitem/index" class="authitem">สิทธิ์การใช้งาน</a></li>
                                </ul>
                            </div>
                        </li>
                    <?php endif;?>
                        <li class="has-sub">
                            <a href="#subSuplier" data-toggle="collapse" class="collapsed"><i class="fa fa-file-code-o"></i> <span>ข้อมูลผู้ขาย</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                            <div id="subSuplier" class="collapse ">
                                <ul class="nav">
                                    <li><a href="index.php?r=supliergroup/index" class="supliergroup">กลุ่มผู้ขาย</a></li>
                                    <li><a href="index.php?r=suplier/index" class="suplier">รหัสผู้ขาย</a></li>
                                </ul>
                            </div>
                        </li>

                    <li class="has-sub">
                        <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>ข้อมูลลูกค้า</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                        <div id="subPages" class="collapse ">
                            <ul class="nav">
                                <li><a href="index.php?r=customergroup/index" class="customergroup">กลุ่มลูกค้า</a></li>
                                <li><a href="index.php?r=customer/index" class="customer">ลูกค้า</a></li>
                            </ul>
                        </div>
                    </li>
                    <?php if(\Yii::$app->user->can('Manage product')):?>
                        <li class="has-sub">
                            <a href="#subProduct" data-toggle="collapse" class="collapsed"><i class="fa fa-cubes"></i> <span>ข้อมูลสินค้า</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                            <div id="subProduct" class="collapse ">
                                <ul class="nav">
                                    <li><a href="index.php?r=productcat/index" class="productcat">กลุ่มสินค้า</a></li>
                                    <li><a href="index.php?r=product/index" class="product">สินค้า</a></li>
                                    <li><a href="index.php?r=unit/index" class="unit">หน่วยนับ</a></li>
                                    <li><a href="index.php?r=warehouse/index" class="warehouse">คลังสินค้า</a></li>
    <!--                                <li><a href="index.php?r=location/index" class="location">ล๊อก</a></li>-->
                                    <li><a href="index.php?r=stockbalance/index" class="stockbalance">สต๊อกสินค้า</a></li>
                                </ul>
                            </div>
                        </li>
                    <?php endif;?>
                    <?php if(\Yii::$app->user->can('Manage purch')):?>
                        <li><a href="index.php?r=purch/index" class="purch"><i class="fa fa-shopping-cart"></i> <span>ซื้อสินค้า</span></a></li>
                    <?php endif;?>
                    <?php if(\Yii::$app->user->can('Manage sale')):?>
                        <li><a href="index.php?r=sale/index" class="sale"><i class="fa fa-diamond"></i> <span>ขายสินค้า</span></a></li>
                    <?php endif;?>
                    <?php if(\Yii::$app->user->can('Manage claim')):?>
                        <li><a href="index.php?r=claim/index" class="claim"><i class="fa fa-bolt"></i> <span>เคลมสินค้า</span></a></li>
                    <?php endif;?>
                    <?php if(\Yii::$app->user->can('Manage loan')):?>
                        <li><a href="index.php?r=loan/index" class="loan"><i class="fa fa-list-alt"></i> <span>สินเชื่อ/ผ่อน</span></a></li>
                    <?php endif;?>
                    <?php if(\Yii::$app->user->can('Manage message')):?>
                        <li><a href="index.php?r=message/index" class="message"><i class="fa fa-comment-o"></i> <span>แจ้งเตือน</span></a></li>
                    <?php endif;?>
                       <li><a href="index.php?r=report/index" class="report"><i class="fa fa-area-chart"></i> <span>รายงาน</span></a></li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- END LEFT SIDEBAR -->
    <!-- MAIN -->
        <div class="main">
            <!-- MAIN CONTENT -->
<!--            <div class="main-content">-->

                <?php $this->beginBody() ?>
            <div class="main-content">
                <div class="container-fluid">
                    <?php
                    echo Breadcrumbs::widget([
                        'options' => ['class'=>'breadcrumb','style'=>'margin-top: -10px;'],
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],

                    ]);
                    ?>
                <?= $content ?>
                </div>
            </div>
                <?php $this->endBody() ?>

<!--            </div>-->
        </div>
    </div>
    </body>
    </html>
<?php $this->endPage() ?>
