<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use andahrm\person\models\Title;
use andahrm\datepicker\DatePicker;
use andahrm\setting\models\WidgetSettings;
use yii\widgets\MaskedInput;

?>
<div class="form-person">
    <div class="row">
        <?= $form->field($model, 'citizen_id', [
            'options' => ['class' => 'form-group col-sm-8'],
            'enableAjaxValidation' => true
        ])->widget(
            MaskedInput::className(),[
            'mask' => '9-9999-99999-99-9'
        ]) ?>
    
    </div>
    
    <div class="row">
        <?= $form->field($model, 'title_id', ['options' => ['class' => 'form-group col-sm-4']])->dropDownList(ArrayHelper::map(Title::find()->all(), 'id', 'name')) ?>
        
        <?= $form->field($model, 'firstname_th', ['options' => ['class' => 'form-group col-sm-4']])->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'lastname_th', ['options' => ['class' => 'form-group col-sm-4']])->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="row">
        <?= $form->field($model, 'firstname_en', ['options' => ['class' => 'form-group col-sm-4 col-sm-offset-4']])->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'lastname_en', ['options' => ['class' => 'form-group col-sm-4']])->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="row">
        <?= $form->field($model, 'gender', ['options' => ['class' => 'form-group col-sm-3']])->inline()->radioList($model->getGenders()) ?>
        
        <?= $form->field($model, 'tel', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'phone', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'birthday', ['options' => ['class' => 'form-group col-sm-3']])->widget(DatePicker::className()) ?>
        
    </div>
</div>

<?php
if($model->isNewRecord) {
$form_id = $form->id;
$firstname_en_id = Html::getInputId($model, "firstname_en");
$username_id = Html::getInputId($modelUser, "username");

$citizen_id_id =  Html::getInputId($model, "citizen_id");
$password_id = Html::getInputId($modelUser, "newPassword");
$passwordConfirm_id = Html::getInputId($modelUser, "newPasswordConfirm");
$js[] = <<< JS
$(document).on('change', '#{$firstname_en_id}', function(event){ 
    var val = $(this).val().toLowerCase(); 
    $('#$username_id').val(val); 
});
$(document).on('change', '#{$citizen_id_id}', function(event){ 
    var val = $(this).val();
    var res = val.replace(/\-/g, '');
    //alert(res);
    $('#$password_id').val(res);
    $('#$passwordConfirm_id').val(res); 
});


// $('#$form_id').yiiActiveForm('add', {
//     id: '$citizen_id_id',
//     name: '$citizen_id_id',
//     container: '.field-person-citizen_id',
//     input: '#$citizen_id_id',
//     error: '.help-block',
//     validate:  function (attribute, value, messages, deferred, \$form) {
//         yii.validation.required(value, messages, {message: "Validation Message Here"});
//     }
// });

JS;
$js['validateCitizenId'] = <<< JS
    $(document).on('blur', "#{$citizen_id_id}",function(){
       
            
                //alert(555);
              
        
    });
JS;

$this->registerJs(implode("\n", $js));
}