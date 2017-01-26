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
                'label' => '<i class="fa fa-info-circle"></i> Address Contact',
                'rowOptions' => ['class' => 'success'],
            ],[
                'attribute' => 'number_registration',
                'label' => $models['address-contact']->getAttributeLabel('number_registration'),
                'value' => $models['address-contact']->number_registration,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-contact'], 'number_registration')->textInput()->label(false);
                }
            ],[
                'attribute' => 'number',
                'label' => $models['address-contact']->getAttributeLabel('number'),
                'value' => $models['address-contact']->number,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-contact'], 'number')->textInput()->label(false);
                }
            ],[
                'attribute' => 'sub_road',
                'label' => $models['address-contact']->getAttributeLabel('sub_road'),
                'value' => $models['address-contact']->number_registration,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-contact'], 'sub_road')->textInput()->label(false);
                }
            ],[
                'attribute' => 'road',
                'label' => $models['address-contact']->getAttributeLabel('road'),
                'value' => $models['address-contact']->road,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-contact'], 'road')->textInput()->label(false);
                }
            ],[
                'attribute' => 'tambol_id',
                'label' => $models['address-contact']->getAttributeLabel('tambol_id'),
                'value' => $models['address-contact']->tambol_id,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-contact'], 'tambol_id')->textInput()->label(false);
                }
            ],[
                'attribute' => 'amphur_id',
                'label' => $models['address-contact']->getAttributeLabel('amphur_id'),
                'value' => $models['address-contact']->amphur_id,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-contact'], 'amphur_id')->textInput()->label(false);
                }
            ],[
                'attribute' => 'province_id',
                'label' => $models['address-contact']->getAttributeLabel('province_id'),
                'value' => $models['address-contact']->province_id,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-contact'], 'province_id')->textInput()->label(false);
                }
            ],[
                'attribute' => 'postcode',
                'label' => $models['address-contact']->getAttributeLabel('postcode'),
                'value' => $models['address-contact']->postcode,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-contact'], 'postcode')->textInput()->label(false);
                }
            ],[
                'attribute' => 'phone',
                'label' => $models['address-contact']->getAttributeLabel('phone'),
                'value' => $models['address-contact']->phone,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-contact'], 'phone')->textInput()->label(false);
                }
            ],[
                'attribute' => 'fax',
                'label' => $models['address-contact']->getAttributeLabel('fax'),
                'value' => $models['address-contact']->fax,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-contact'], 'fax')->textInput()->label(false);
                }
            ],[
                'attribute' => 'move_in_date',
                'label' => $models['address-contact']->getAttributeLabel('move_in_date'),
                'value' => $models['address-contact']->move_in_date,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-contact'], 'move_in_date')->widget(DatePicker::className(), WidgetSettings::DatePicker());
                }
            ],[
                'attribute' => 'move_out_date',
                'label' => $models['address-contact']->getAttributeLabel('move_out_date'),
                'value' => $models['address-contact']->move_out_date,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-contact'], 'move_out_date')->widget(DatePicker::className(), WidgetSettings::DatePicker());
                }
            ]
];