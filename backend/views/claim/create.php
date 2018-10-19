<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Claim */

$this->title = 'สร้างรายการเคลมสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'เคลมสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="claim-create">

    <?= $this->render('_form', [
        'model' => $model,
        'runno' => $runno,
    ]) ?>

</div>
