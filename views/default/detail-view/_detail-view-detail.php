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
        'label' => '<i class="fa fa-info-circle"></i> Detail',
        'rowOptions' => ['class' => 'success'],
    ],*/[
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
        'attribute' => 'religion_id',
        'label' => $model->getAttributeLabel('religion_id'),
        'value' => $model->religion->title,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'religion_id')->inline()->radioList(ArrayHelper::map(Religion::find()->all(), 'id', 'title'))->label(false);
        }
    ],[
        'attribute' => 'blood_group',
        'label' => Yii::t('andahrm/person', 'blood_group'),
        'value' => $model->getBloodGroupText(),
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'blood_group')->inline()->radioList($model->getBloodGroups())->label(false);
        }
    ],[
        'attribute' => 'married_status',
        'label' => $model->getAttributeLabel('married_status'),
        'value' => $model->getStatusText(),
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'married_status')->inline()->radioList($model->getStatuses())->label(false);
        }
    ],
];