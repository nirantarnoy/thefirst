<?php
use yii\helpers\Url;
use backend\themes\klolofil\assets\KlolofilAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;



/* @var $this \yii\web\View */
/* @var $content string */

KlolofilAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@klolofil/dist');

$this->registerCss('
     body{
                font-family: "Cloud-Light";
               
            }
');
?>
<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="vendor/linearicons/style.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="css/main.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="img/favicon.png">
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
						<div class="content">
                            <div style="padding-left: 30%;padding-right: 30%;">
                                <div class="header">
                                    <div class="logo text-center" style="font-family: Cloud-Light;text-align: center"><h2>The First</h2></div>
                                    <br>
                                    <p class="lead" style="font-family: Cloud-Light;font-size: 24px;">ลงชื่อเข้าใช้งานระบบ</p>
                                </div>
                                <div style="width: 100%;text-align: center">
                                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                                    <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>'ชื่อผู้ใช้งาน','class'=>'form-control','style'=>'font-family: Cloud-Light;font-size: 18px;'])->label(false) ?>

                                    <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'รหัสผ่าน','style'=>'font-family: Cloud-Light;font-size: 18px;'])->label(false) ?>

                                    <?= $form->field($model, 'rememberMe')->checkbox(['label'=>'ให้ฉันอยู่ในระบบตลอดไป','labelOptions'=>['style'=>'font-family: Cloud-Light;font-size: 18px;']])->label() ?>

                                    <div class="form-group" style="font-family: Cloud-Bold;font-size: 24px;">
                                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                                    </div>

                                    <?php ActiveForm::end(); ?>
                                </div>

                        </div>
						</div>


					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>
