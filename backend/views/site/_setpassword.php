<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$url_to_reset=Url::to(['site/resetpassword'],true);
?>
<?php $form = ActiveForm::begin()?>
<div class="row">
    <div class="col-lg-6">
        <?php echo $form->field($model,'oldpw')->passwordInput()->label()?>
        <?php echo $form->field($model,'newpw')->passwordInput()->label()?>
        <?php echo $form->field($model,'confirmpw')->passwordInput()->label()?>
        <div class="form-group">
            <input type="submit" value="Save" class="btn btn-success">
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
