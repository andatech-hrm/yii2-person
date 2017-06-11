<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use andahrm\person\models\Title;
use kuakling\datepicker\DatePicker;
use andahrm\setting\models\WidgetSettings;
use yii\widgets\MaskedInput;
use andahrm\person\models\Person;

?>
<div class="form-person">
    
    <h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
        <i class="<?= $this->context->formSteps[$step]['icon']; ?>"></i> Step <?=$step?>.1
        <span class="text-muted"><?= Yii::t('andahrm/person','Basic Information'); ?></span>
    </h2> 
    
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
    
    
    <h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
        <i class="<?= $this->context->formSteps[$step]['icon']; ?>"></i> Step <?=$step?>.2
        <span class="text-muted"><?= $this->context->formSteps[$step]['desc']; ?></span>
    </h2> 
    <!--<h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">-->
    <!--    <i class="<?= $this->context->formSteps[1]['icon']; ?>"></i> Step 1 -->
    <!--    <span class="text-muted"><?= $this->context->formSteps[1]['desc']; ?></span>-->
    <!--</h2>-->
    
        <?php 
        if($modelUser->isNewRecord){
            echo $form->field($modelUser, 'username',['enableAjaxValidation' => true ])->label(Yii::t('andahrm/person', 'Username'));
         }else{
            echo Html::activeLabel($modelUser,'username').' : '.$modelUser->username;
        }
        ?>

        <?= $form->field($modelUser, 'email',[ 'enableAjaxValidation' => true])->label(Yii::t('andahrm/person', 'Email'));?>
        
        <?php if($modelUser->isNewRecord) : ?>
            <?= $form->field($modelUser, 'newPassword')->passwordInput()->label(Yii::t('andahrm/person', 'Password'));?>
    
            <?= $form->field($modelUser, 'newPasswordConfirm')->passwordInput()->label(Yii::t('andahrm/person', 'Confirm password'));?>
        <?php endif; ?>
        
        <?= $form->field($modelUser, 'status')->inline()->radioList($modelUser->getStatusList())->label(Yii::t('andahrm/person', 'Status'));?>
        
        
            <?php 
            $roles = Yii::$app->authManager->getRolesByUser($modelUser->id);
            ?>
        <div class="form-group required">
            <label class="control-label" for="role"><?= Yii::t('andahrm/person', 'Roles'); ?></label>
            <div class="well">
            <?= Html::checkBoxList('Roles', array_keys($roles), Person::getRoleList(), ['separator' => '<br>']); ?>
            </div>
            <?php //echo Html::dropDownList('role', null, $roleList, ['class'=>'form-control', 'id' => 'role']); ?>
        </div>
        <?php
        if(!$modelUser->isNewRecord) {
            echo Html::a('<i class="fa fa-user-secret"></i> Manage Account', ['/user/admin'], ['class' => 'btn btn-dark btn-block text-red', 'target' => '_blank']);
        }
        ?>
    
    
    
</div>

<?php
if($model->isNewRecord) {
    $form_id = $form->id;
    $firstname_en_id = Html::getInputId($model, "firstname_en");
    $lastname_en_id = Html::getInputId($model, "lastname_en");
    $username_id = Html::getInputId($modelUser, "username");
    
    $citizen_id_id =  Html::getInputId($model, "citizen_id");
    $password_id = Html::getInputId($modelUser, "newPassword");
    $passwordConfirm_id = Html::getInputId($modelUser, "newPasswordConfirm");
    
    $urlChkUsername = Url::to(['check-username']);
    
    $js[] = <<< JS
    $(document).on('change', '#{$firstname_en_id}, #{$lastname_en_id}', function(event){ 
        var valF = $("#{$firstname_en_id}").val().toLowerCase(); 
        var valL = $("#{$lastname_en_id}").val().toLowerCase(); 
        
        if(valF && valL){
            $.get("{$urlChkUsername}",{
                'firstname_en':valF,
                'lastname_en':valL,
            },function(data){
                $('#$username_id').val(data); 
            });
        }
    });
    
    $(document).on('change', '#{$citizen_id_id}', function(event){ 
        var val = $(this).val();
        var res = val.replace(/\-/g, '');
        //alert(res);
        $('#$password_id').val(res);
        $('#$passwordConfirm_id').val(res); 
    });


JS;

$this->registerJs(implode("\n", $js));
}