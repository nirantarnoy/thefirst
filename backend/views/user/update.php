<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', 'แก้ไขผู้ใช้งาน: {nameAttribute}', [
    'nameAttribute' => $model->username,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ผู้ใช้งาน'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
