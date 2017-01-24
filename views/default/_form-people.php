<?php
use yii\helpers\ArrayHelper;

use andahrm\setting\models\WidgetSettings;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Child */
/* @var $form yii\widgets\ActiveForm */
// if($model->isNewRecord)
?>
<div class="row">
        <?= $form->field($model, 'citizen_id', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'name', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'surname', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'birthday', ['options' => ['class' => 'form-group col-sm-3']])->widget(DatePicker::className(), WidgetSettings::DatePicker()) ?>
    </div>
    
    <div class="row">

        <?= $form->field($model, 'nationality_id', ['options' => ['class' => 'form-group col-sm-3']])->widget(Select2::classname(), WidgetSettings::Select2([
            'data' => ArrayHelper::map($this->context->nationalities, 'id', 'title'),
        ])) ?>

        <?= $form->field($model, 'race_id', ['options' => ['class' => 'form-group col-sm-3']])->widget(Select2::classname(), WidgetSettings::Select2([
            'data' => ArrayHelper::map($this->context->races, 'id', 'title'),
        ])) ?>

        <?= $form->field($model, 'occupation', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'live_status', ['options' => ['class' => 'form-group col-sm-3']])->inline()->radioList($model::getLiveStatuses()) ?>
        
    </div>
<?php /*
    <!-- Begin People -->
    <?= $form->field($model, 'citizen_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'birthday')->widget(DatePicker::className(), WidgetSettings::DatePicker()) ?>
    
    <?= $form->field($model, 'nationality_id')->widget(Select2::classname(), WidgetSettings::Select2([
        'data' => ArrayHelper::map($this->context->nationalities, 'id', 'title'),
    ])) ?>

    <?= $form->field($model, 'race_id')->widget(Select2::classname(), WidgetSettings::Select2([
        'data' => ArrayHelper::map($this->context->races, 'id', 'title'),
    ])) ?>
    
    <?= $form->field($model, 'occupation')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'live_status')->inline()->radioList($model::getLiveStatuses()) ?>
    */ ?>