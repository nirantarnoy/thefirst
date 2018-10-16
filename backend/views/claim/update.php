<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Claim */

$this->title = 'แก้ไขรายการเคลม: ' . $model->claim_no;
$this->params['breadcrumbs'][] = ['label' => 'เคลมสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->claim_no, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="claim-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelline' => $modelline,
    ]) ?>

</div>
