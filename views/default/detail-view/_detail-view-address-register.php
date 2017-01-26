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
                'label' => '<i class="fa fa-info-circle"></i> Address Register',
                'rowOptions' => ['class' => 'success'],
            ],[
                'attribute' => 'number_registration',
                'label' => $models['address-register']->getAttributeLabel('number_registration'),
                'value' => $models['address-register']->number_registration,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-register'], 'number_registration')->textInput()->label(false);
                }
            ],[
                'attribute' => 'number',
                'label' => $models['address-register']->getAttributeLabel('number'),
                'value' => $models['address-register']->number,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-register'], 'number')->textInput()->label(false);
                }
            ],[
                'attribute' => 'sub_road',
                'label' => $models['address-register']->getAttributeLabel('sub_road'),
                'value' => $models['address-register']->number_registration,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-register'], 'sub_road')->textInput()->label(false);
                }
            ],[
                'attribute' => 'road',
                'label' => $models['address-register']->getAttributeLabel('road'),
                'value' => $models['address-register']->road,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-register'], 'road')->textInput()->label(false);
                }
            ],[
                'attribute' => 'tambol_id',
                'label' => $models['address-register']->getAttributeLabel('tambol_id'),
                'value' => $models['address-register']->tambol_id,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-register'], 'tambol_id')->textInput()->label(false);
                }
            ],[
                'attribute' => 'amphur_id',
                'label' => $models['address-register']->getAttributeLabel('amphur_id'),
                'value' => $models['address-register']->amphur_id,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-register'], 'amphur_id')->textInput()->label(false);
                }
            ],[
                'attribute' => 'province_id',
                'label' => $models['address-register']->getAttributeLabel('province_id'),
                'value' => $models['address-register']->province_id,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-register'], 'province_id')->textInput()->label(false);
                }
            ],[
                'attribute' => 'postcode',
                'label' => $models['address-register']->getAttributeLabel('postcode'),
                'value' => $models['address-register']->postcode,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-register'], 'postcode')->textInput()->label(false);
                }
            ],[
                'attribute' => 'phone',
                'label' => $models['address-register']->getAttributeLabel('phone'),
                'value' => $models['address-register']->phone,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-register'], 'phone')->textInput()->label(false);
                }
            ],[
                'attribute' => 'fax',
                'label' => $models['address-register']->getAttributeLabel('fax'),
                'value' => $models['address-register']->fax,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-register'], 'fax')->textInput()->label(false);
                }
            ],[
                'attribute' => 'move_in_date',
                'label' => $models['address-register']->getAttributeLabel('move_in_date'),
                'value' => $models['address-register']->move_in_date,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-register'], 'move_in_date')->widget(DatePicker::className(), WidgetSettings::DatePicker());
                }
            ],[
                'attribute' => 'move_out_date',
                'label' => $models['address-register']->getAttributeLabel('move_out_date'),
                'value' => $models['address-register']->move_out_date,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-register'], 'move_out_date')->widget(DatePicker::className(), WidgetSettings::DatePicker());
                }
            ]
];