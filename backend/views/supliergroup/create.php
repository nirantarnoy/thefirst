<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Vendorgroup */

$this->title = Yii::t('app', 'สร้างกลุ่มผู้ขาย');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'กลุ่มผู้ขาย'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendorgroup-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
