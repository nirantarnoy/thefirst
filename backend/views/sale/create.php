<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Sale */

$this->title = Yii::t('app', 'สร้างการขาย');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'รายการขาย'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-create">

    <?= $this->render('_form', [
        'model' => $model,
        'runno' => $runno,
    ]) ?>

</div>
