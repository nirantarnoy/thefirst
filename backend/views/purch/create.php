<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Purch */

$this->title = Yii::t('app', 'สร้างรายการซื้อ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'รายการซื้อ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purch-create">
    <?= $this->render('_form', [
        'model' => $model,
        'runno' => $runno,
    ]) ?>

</div>
