<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Loanpayment */

$this->title = Yii::t('app', 'Create Loanpayment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Loanpayments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loanpayment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
