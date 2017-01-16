<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use andahrm\person\models\People;
use andahrm\person\models\Nationality;
use andahrm\person\models\Race;
use andahrm\setting\models\Helper;

use andahrm\setting\models\WidgetSettings;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Child */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="child-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="pull-right">
    <?= Html::a('<i class="fa fa-times"></i> Discard', Helper::urlParams('index'), ['class' => 'btn btn-default']) ?>
    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check"></i> '.Yii::t('app', 'Create') : '<i class="fa fa-check"></i> '.Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <h4><?= Html::encode($this->title) ?></h4>
    <hr>

    <?= Html::activeHiddenInput($model, 'user_id') ?>

    <?php //echo $form->field($model, 'people_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'relation')->textInput(['maxlength' => true]) ?>
    
    <!-- Begin People -->
    <?= $form->field($modelPeople, 'citizen_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($modelPeople, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($modelPeople, 'surname')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($modelPeople, 'birthday')->widget(DatePicker::className(), WidgetSettings::DatePicker()) ?>
    
    <?= $form->field($modelPeople, 'nationality_id')->widget(Select2::classname(), array_replace_recursive(WidgetSettings::Select2(), [
        'data' => ArrayHelper::map(Nationality::find()->all(), 'id', 'title'),
    ])) ?>

    <?= $form->field($modelPeople, 'race_id')->widget(Select2::classname(), array_replace_recursive(WidgetSettings::Select2(), [
        'data' => ArrayHelper::map(Race::find()->all(), 'id', 'title'),
    ])) ?>
    
    <?= $form->field($modelPeople, 'occupation')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($modelPeople, 'live_status')->inline()->radioList(People::getLiveStatuses()) ?>
    <!-- End People -->

    <div class="form-group pull-right">
        <?= Html::a('<i class="fa fa-times"></i> Discard', Helper::urlParams('index'), ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check"></i> '.Yii::t('app', 'Create') : '<i class="fa fa-check"></i> '.Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
