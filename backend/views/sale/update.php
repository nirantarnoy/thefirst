<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Sale */

$this->title = Yii::t('app', 'แก้ไขรายการ: ' . $model->sale_no, [
    'nameAttribute' => '' . $model->sale_no,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'รายการขาย'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sale_no, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'แก้ไข');
?>
<div class="sale-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelline' =>$modelline,
    ]) ?>

</div>
