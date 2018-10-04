<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Plant */

$this->title = Yii::t('app', 'ข้อมูลร้าน');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ข้อมูลร้าน'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plant-create">
    <?= $this->render('_form', [
        'model' => $model,
        'model_address' => $model_address,
        'model_address_plant' => $model_address_plant,
    ]) ?>

</div>
