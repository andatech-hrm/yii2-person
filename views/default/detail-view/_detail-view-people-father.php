<?php
use kartik\detail\DetailView;
use andahrm\person\models\Religion;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use andahrm\setting\models\WidgetSettings;


return [
    [
                'group' => true,
                'label' => '<i class="fa fa-info-circle"></i> Father',
                'rowOptions' => ['class' => 'success'],
            ],[
                'attribute' => 'citizen_id',
                'label' => $models['people-father']->getAttributeLabel('citizen_id'),
                'value' => $models['people-father']->citizen_id,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['people-father'], 'citizen_id')->textInput()->label(false);
                }
            ],[
                'attribute' => 'name',
                'label' => $models['people-father']->getAttributeLabel('name'),
                'value' => $models['people-father']->name,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['people-father'], 'name')->textInput()->label(false);
                }
            ],[
                'attribute' => 'surname',
                'label' => $models['people-father']->getAttributeLabel('surname'),
                'value' => $models['people-father']->surname,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['people-father'], 'surname')->textInput()->label(false);
                }
            ],[
                'attribute' => 'birthday',
                'label' => $models['people-father']->getAttributeLabel('birthday'),
                'value' => $models['people-father']->birthday,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['people-father'], 'birthday')->widget(DatePicker::className(), WidgetSettings::DatePicker());
                }
            ],[
                'attribute' => 'nationality_id',
                'label' => $models['people-father']->getAttributeLabel('nationality_id'),
                'value' => $models['people-father']->nationality_id,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['people-father'], 'nationality_id')->widget(Select2::classname(), WidgetSettings::Select2([
                        'data' => ArrayHelper::map($this->context->nationalities, 'id', 'title'),
                    ]));
                }
            ],[
                'attribute' => 'race_id',
                'label' => $models['people-father']->getAttributeLabel('race_id'),
                'value' => $models['people-father']->race_id,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['people-father'], 'race_id')->widget(Select2::classname(), WidgetSettings::Select2([
                        'data' => ArrayHelper::map($this->context->races, 'id', 'title'),
                    ]));
                }
            ],[
                'attribute' => 'occupation',
                'label' => $models['people-father']->getAttributeLabel('occupation'),
                'value' => $models['people-father']->occupation,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['people-father'], 'occupation')->textInput()->label(false);
                }
            ],[
                'attribute' => 'live_status',
                'label' => $models['people-father']->getAttributeLabel('live_status'),
                'value' => $models['people-father']->getLiveStatusText(),
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['people-father'], 'live_status')->inline()->radioList($models['people-father']::getLiveStatuses())->label(false);
                }
            ],
];