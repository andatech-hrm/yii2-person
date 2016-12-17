<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Person */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-form">
    <?= Yii::t('app', 'Welcome'); ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title">
                <h2>Information</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= $form->field($model, 'citizen_id')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'title_id')->textInput() ?>

                <?= $form->field($model, 'firstname_th')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'lastname_th')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'firstname_en')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'lastname_en')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'gender')->dropDownList([ 'f' => 'F', 'm' => 'M', ], ['prompt' => '']) ?>

                <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'birthday')->textInput() ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <?php 
        echo $this->render('_signup', [
            'model' => $modelUser,
            'form' => $form,
            'roleList' => $model->getRoleList()
        ]); 
        ?>
    </div>
    </div>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$firstname_en_id = Html::getInputId($model, "firstname_en");
$username_id = Html::getInputId($modelUser, "username");

$citizen_id_id =  Html::getInputId($model, "citizen_id");
$password_id = Html::getInputId($modelUser, "newPassword");
$passwordConfirm_id = Html::getInputId($modelUser, "newPasswordConfirm");
$js[] = <<< JS
$(document).on('change', '#{$firstname_en_id}', function(event){ var val = $(this).val().toLowerCase(); $('#$username_id').val(val); });
$(document).on('change', '#{$citizen_id_id}', function(event){ var val = $(this).val().toLowerCase(); $('#$password_id').val(val); $('#$passwordConfirm_id').val(val); });
JS;


$this->registerJs(implode("\n", $js));