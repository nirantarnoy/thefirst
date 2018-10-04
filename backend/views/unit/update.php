<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Unit */

$this->title = Yii::t('app', 'แก้ไขหน่วยนับ: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'หน่วยนับ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="unit-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
