<?php
use kartik\detail\DetailView;
use andahrm\person\models\Religion;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kuakling\datepicker\DatePicker;
use andahrm\setting\models\WidgetSettings;


return [
    [
            //     'group' => true,
            //     'label' => '<i class="fa fa-info-circle"></i> Address Birth Place',
            //     'rowOptions' => ['class' => 'success'],
            // ],[
                'attribute' => 'number_registration',
                'label' => $models['address-birth-place']->getAttributeLabel('number_registration'),
                'value' => $models['address-birth-place']->number_registration,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-birth-place'], 'number_registration')->textInput()->label(false);
                }
            ],[
                'attribute' => 'number',
                'label' => $models['address-birth-place']->getAttributeLabel('number'),
                'value' => $models['address-birth-place']->number,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-birth-place'], 'number')->textInput()->label(false);
                }
            ],[
                'attribute' => 'sub_road',
                'label' => $models['address-birth-place']->getAttributeLabel('sub_road'),
                'value' => $models['address-birth-place']->number_registration,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-birth-place'], 'sub_road')->textInput()->label(false);
                }
            ],[
                'attribute' => 'road',
                'label' => $models['address-birth-place']->getAttributeLabel('road'),
                'value' => $models['address-birth-place']->road,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-birth-place'], 'road')->textInput()->label(false);
                }
            ],[
                'attribute' => 'tambol_id',
                'label' => $models['address-birth-place']->getAttributeLabel('tambol_id'),
                'value' => $models['address-birth-place']->tambol_id,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-birth-place'], 'tambol_id')->textInput()->label(false);
                }
            ],[
                'attribute' => 'amphur_id',
                'label' => $models['address-birth-place']->getAttributeLabel('amphur_id'),
                'value' => $models['address-birth-place']->amphur_id,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-birth-place'], 'amphur_id')->textInput()->label(false);
                }
            ],[
                'attribute' => 'province_id',
                'label' => $models['address-birth-place']->getAttributeLabel('province_id'),
                'value' => $models['address-birth-place']->province_id,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-birth-place'], 'province_id')->textInput()->label(false);
                }
            ],[
                'attribute' => 'postcode',
                'label' => $models['address-birth-place']->getAttributeLabel('postcode'),
                'value' => $models['address-birth-place']->postcode,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-birth-place'], 'postcode')->textInput()->label(false);
                }
            ],[
                'attribute' => 'phone',
                'label' => $models['address-birth-place']->getAttributeLabel('phone'),
                'value' => $models['address-birth-place']->phone,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-birth-place'], 'phone')->textInput()->label(false);
                }
            ],[
                'attribute' => 'fax',
                'label' => $models['address-birth-place']->getAttributeLabel('fax'),
                'value' => $models['address-birth-place']->fax,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-birth-place'], 'fax')->textInput()->label(false);
                }
            ],[
                'attribute' => 'move_in_date',
                'label' => $models['address-birth-place']->getAttributeLabel('move_in_date'),
                'value' => $models['address-birth-place']->move_in_date,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-birth-place'], 'move_in_date')->widget(DatePicker::className(), WidgetSettings::DatePicker());
                }
            ],[
                'attribute' => 'move_out_date',
                'label' => $models['address-birth-place']->getAttributeLabel('move_out_date'),
                'value' => $models['address-birth-place']->move_out_date,
                'updateMarkup' => function($form, $widget) use ($models) {
                    return $form->field($models['address-birth-place'], 'move_out_date')->widget(DatePicker::className(), WidgetSettings::DatePicker());
                }
            ]
];