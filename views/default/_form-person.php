<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use andahrm\person\models\Title;
use kartik\widgets\DatePicker;
use andahrm\setting\models\WidgetSettings;
?>
<div class="form-person">
            
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