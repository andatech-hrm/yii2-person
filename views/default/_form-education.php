<?php
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use andahrm\setting\models\WidgetSettings;
?>
<div class="row">
    <?= $form->field($model, "year_start", ['options' => ['class' => 'form-group col-sm-2']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, "year_end", ['options' => ['class' => 'form-group col-sm-2']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, "level_id", ['options' => ['class' => 'form-group col-sm-3']])->dropDownList(ArrayHelper::map($this->context->educationLevels, 'id', 'title')) ?>
    <?= $form->field($model, "degree", ['options' => ['class' => 'form-group col-sm-2']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, "branch", ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
</div><!-- end:row -->

<div class="row">
    <?= $form->field($model, "institution", ['options' => ['class' => 'form-group col-sm-4']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, "province", ['options' => ['class' => 'form-group col-sm-4']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, "country_id", ['options' => ['class' => 'form-group col-sm-4']])->widget(Select2::classname(), WidgetSettings::Select2([
        'data' => ArrayHelper::map($this->context->nationalities, 'id', 'title')
    ])) ?>

</div><!-- end:row -->