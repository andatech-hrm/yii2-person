<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use andahrm\person\models\Nationality;
use andahrm\person\models\Race;
use andahrm\person\models\Religion;

use andahrm\person\models\WidgetSettings;
use kartik\widgets\Select2;
?>
    <?= Html::activeHiddenInput($model, 'user_id'); ?>

    <?= $form->field($model, 'nationality_id')->widget(Select2::classname(), array_replace_recursive(WidgetSettings::Select2(), [
        'data' => ArrayHelper::map(Nationality::find()->all(), 'id', 'title'),
    ])) ?>

    <?= $form->field($model, 'race_id')->widget(Select2::classname(), array_replace_recursive(WidgetSettings::Select2(), [
        'data' => ArrayHelper::map(Race::find()->all(), 'id', 'title'),
    ])) ?>

    <?= $form->field($model, 'religion_id')->inline()->radioList(ArrayHelper::map(Religion::find()->all(), 'id', 'title')) ?>

    <?= $form->field($model, 'blood_group')->inline()->radioList($model->getBloodGroups()) ?>

    <?= $form->field($model, 'address_contact_id')->textInput() ?>

    <?= $form->field($model, 'address_birth_place_id')->textInput() ?>

    <?= $form->field($model, 'address_register_id')->textInput() ?>

    <?= $form->field($model, 'mother_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'father_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'married_status')->inline()->radioList($model->getStatuses()) ?>

    <?= $form->field($model, 'people_spouse_id')->textInput() ?>