<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use andahrm\person\models\Religion;

use andahrm\setting\models\WidgetSettings;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
?>
<?php
if($model->isNewRecord) {
    $model->nationality_id = $model::DEFAULT_NATIONALITY;
    $model->race_id = $model::DEFAULT_RACE;
}
?>
    <?= Html::activeHiddenInput($model, 'user_id'); ?>
<div class="row">
    <?= $form->field($model, 'nationality_id', ['options' => ['class' => 'form-group col-sm-6']])->widget(Select2::classname(), array_replace_recursive(WidgetSettings::Select2(), [
        'data' => ArrayHelper::map($this->context->nationalities, 'id', 'title'),
    ])) ?>

    <?= $form->field($model, 'race_id', ['options' => ['class' => 'form-group col-sm-6']])->widget(Select2::classname(), array_replace_recursive(WidgetSettings::Select2(), [
        'data' => ArrayHelper::map($this->context->races, 'id', 'title'),
    ])) ?>
</div>
<div class="row">
    <?= $form->field($model, 'religion_id', ['options' => ['class' => 'form-group col-sm-6']])->inline()->radioList(ArrayHelper::map(Religion::find()->all(), 'id', 'title')) ?>

    <?= $form->field($model, 'blood_group', ['options' => ['class' => 'form-group col-sm-6']])->inline()->radioList($model->getBloodGroups()) ?>

</div>
    <?= $form->field($model, 'married_status')->inline()->radioList($model->getStatuses()) ?>
<div id="group_spouse" style="display:none;">
    <h4>Spouse</h4>
    <div class="row">
        <?= $form->field($modelSpouse, 'citizen_id', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($modelSpouse, 'name', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($modelSpouse, 'surname', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($modelSpouse, 'birthday', ['options' => ['class' => 'form-group col-sm-3']])->widget(DatePicker::className(), WidgetSettings::DatePicker()) ?>
    </div>
    
    <div class="row">

        <?= $form->field($modelSpouse, 'nationality_id', ['options' => ['class' => 'form-group col-sm-3']])->widget(Select2::classname(), WidgetSettings::Select2([
            'data' => ArrayHelper::map($this->context->nationalities, 'id', 'title'),
        ])) ?>

        <?= $form->field($modelSpouse, 'race_id', ['options' => ['class' => 'form-group col-sm-3']])->widget(Select2::classname(), WidgetSettings::Select2([
            'data' => ArrayHelper::map($this->context->races, 'id', 'title'),
        ])) ?>

        <?= $form->field($modelSpouse, 'occupation', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($modelSpouse, 'live_status', ['options' => ['class' => 'form-group col-sm-3']])->inline()->radioList($modelSpouse::getLiveStatuses()) ?>
    </div>
</div>

<?php
$fieldStatusId = Html::getInputId($model, 'married_status');

$js[] = <<< JS
$(document).on('change', '#{$fieldStatusId} input:radio', function(e){
    if($(this).val() == 1) {
        $('#group_spouse').slideDown();
    }else{
        $('#group_spouse').slideUp();
    }
});
JS;

$js[] = <<< JS
$('#{$fieldStatusId} input:radio[checked]').trigger('change');
JS;
    
$this->registerJs(implode("\n", $js));