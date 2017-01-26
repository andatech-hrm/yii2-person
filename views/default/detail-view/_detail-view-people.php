<?php
use kartik\detail\DetailView;
use andahrm\person\models\Religion;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use andahrm\setting\models\WidgetSettings;


return [
    /*[
        'group' => true,
        'label' => '<i class="fa fa-info-circle"></i> Father',
        'rowOptions' => ['class' => 'success'],
    ],*/[
        'attribute' => 'citizen_id',
        'label' => $model->getAttributeLabel('citizen_id'),
        'value' => $model->citizen_id,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'citizen_id')->textInput()->label(false);
        }
    ],[
        'attribute' => 'name',
        'label' => $model->getAttributeLabel('name'),
        'value' => $model->name,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'name')->textInput()->label(false);
        }
    ],[
        'attribute' => 'surname',
        'label' => $model->getAttributeLabel('surname'),
        'value' => $model->surname,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'surname')->textInput()->label(false);
        }
    ],[
        'attribute' => 'birthday',
        'label' => $model->getAttributeLabel('birthday'),
        'value' => $model->birthday,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'birthday')->widget(DatePicker::className(), WidgetSettings::DatePicker());
        }
    ],[
        'attribute' => 'nationality_id',
        'label' => $model->getAttributeLabel('nationality_id'),
        'value' => $model->nationality->title,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'nationality_id')->widget(Select2::classname(), WidgetSettings::Select2([
        'data' => ArrayHelper::map($this->nationalities, 'id', 'title'),
            ]));
        }
    ],[
        'attribute' => 'race_id',
        'label' => $model->getAttributeLabel('race_id'),
        'value' => $model->race->title,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'race_id')->widget(Select2::classname(), WidgetSettings::Select2([
        'data' => ArrayHelper::map($this->races, 'id', 'title'),
            ]));
        }
    ],[
        'attribute' => 'occupation',
        'label' => $model->getAttributeLabel('occupation'),
        'value' => $model->occupation,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'occupation')->textInput()->label(false);
        }
    ],[
        'attribute' => 'live_status',
        'label' => $model->getAttributeLabel('live_status'),
        'value' => $model->getLiveStatusText(),
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'live_status')->inline()->radioList($model::getLiveStatuses())->label(false);
        }
    ],
];