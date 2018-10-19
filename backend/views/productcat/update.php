<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Productcat */

$this->title = Yii::t('app', 'แก้ไขกลุ่มสินค้า: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'กลุ่มสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="productcat-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
