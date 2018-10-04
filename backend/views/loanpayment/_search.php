<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\LoanpaymentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loanpayment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'loan_id') ?>

    <?= $form->field($model, 'period_pay') ?>

    <?= $form->field($model, 'payment_type') ?>

    <?= $form->field($model, 'payment_date') ?>

    <?php // echo $form->field($model, 'payment_by') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'fee') ?>

    <?php // echo $form->field($model, 'fine') ?>

    <?php // echo $form->field($model, 'fine_type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
