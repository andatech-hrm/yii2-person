<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use andahrm\person\models\Title;
use kartik\widgets\DatePicker;
use andahrm\setting\models\WidgetSettings;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Person */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="person-form">
<?php $form = ActiveForm::begin(); ?>
    <div class="pull-right">
    <?= Html::a('<i class="fa fa-times"></i> Discard', ['index'], ['class' => 'btn btn-default']) ?>
    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check"></i> '.Yii::t('app', 'Create') : '<i class="fa fa-check"></i> '.Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <h4><?= $model->isNewRecord ? Yii::t('andahrm', 'Create Person') : $model->fullname; ?></h4>
    <hr>
    
    
    <div class="row">
        <div class="col-sm-6">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Default <small>Hover to view</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
            
                    <?= $form->field($model, 'citizen_id')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'title_id')->dropDownList(ArrayHelper::map(Title::find()->all(), 'id', 'name')) ?>

                    <?= $form->field($model, 'firstname_th')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'lastname_th')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'firstname_en')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'lastname_en')->textInput(['maxlength' => true]) ?>
                    
                    <?= $form->field($model, 'gender')->inline()->radioList($model->getGenders()) ?>

                    <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'birthday')->widget(DatePicker::className(), WidgetSettings::DatePicker()) ?>

                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="x_panel">
                <div class="x_title">
                    <h2>User Account <small>Hover to view</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php 
                    echo $this->render('_signup', [
                        'model' => $modelUser,
                        'form' => $form,
                        'roleList' => $model->getRoleList()
                    ]); 
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
    
    <div>
        <?php 
        if($model->isNewRecord) {
            echo Yii::$app->runAction('/person/detail/create', ['form' => $form]);
        }else{
            echo Yii::$app->runAction('/person/detail/update', ['id' => $model->user_id, 'form' => $form]);
        }
        ?>
    </div>
</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
if($model->isNewRecord) {
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
}
?>