<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Purch */

$this->title = Yii::t('app', 'แก้ไขรายการ: ' . $model->purch_no, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'รายการซื้อ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->purch_no, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'แก้ไข');
?>
<div class="purch-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelline'=>$modelline,
    ]) ?>

</div>
