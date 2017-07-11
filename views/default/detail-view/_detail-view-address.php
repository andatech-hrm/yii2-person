<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;
use andahrm\person\models\Religion;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use andahrm\datepicker\DatePicker;
use andahrm\setting\models\WidgetSettings;

$model->localRegion = ($model->province !== null) ? $model->province->region_id : null;

return [
    /*[
        'group' => true,
        'label' => '<i class="fa fa-info-circle"></i> '.Yii::t('andahrm/person', $header),
        'rowOptions' => ['class' => 'success'],
    ],*/[
        'attribute' => 'number_registration',
        'label' => $model->getAttributeLabel('number_registration'),
        'value' => $model->number_registration,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'number_registration')->textInput()->label(false);
        }
    ],[
        'attribute' => 'number',
        'label' => $model->getAttributeLabel('number'),
        'value' => $model->number,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'number')->textInput()->label(false);
        }
    ],[
        'attribute' => 'sub_road',
        'label' => $model->getAttributeLabel('sub_road'),
        'value' => $model->number_registration,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'sub_road')->textInput()->label(false);
        }
    ],[
        'attribute' => 'road',
        'label' => $model->getAttributeLabel('road'),
        'value' => $model->road,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'road')->textInput()->label(false);
        }
    ],[
        'attribute' => 'localRegion',
        'label' => $model->getAttributeLabel('localRegion'),
        'value' => function($form, $widget) {
            $model = $widget->model;
            if($model->isNewRecord) { return null; }
            return 'ต.' . $model->tambol->name . ' อ.'.$model->amphur->name . 'จ.' . $model->province->name;
        },
        'updateMarkup' => function($form, $widget) use ($model) {
            return '<div class="address-pane">' . 
            $form->field($model, 'localRegion')->inline()->radioList(
                ArrayHelper::map($this->localReligions, 'id', 'name'), 
                [
                    'data-province-json' => Url::to(['/setting/local-province/json']), 
                    'class' => 'local-region'
                ]
            )->label(false) . 
            '<label>' . $model->getAttributeLabel('province_id') . '</label>'.
            $form->field($model, 'province_id', [
                'options' => ['class' => 'form-group addr-province'], 
                'inputOptions' => ['data-name' => 'province_id']
            ])->widget(Select2::classname(), WidgetSettings::Select2()) . 
                Html::hiddenInput('oldProvince', $model->province_id) . 
            
            '<label>' . $model->getAttributeLabel('amphur_id') . '</label>'.
            $form->field($model, 'amphur_id', [
                'options' => ['class' => 'form-group addr-amphur'], 
                'inputOptions' => ['data-name' => 'amphur_id']
            ])->widget(Select2::classname(), WidgetSettings::Select2()) . 
                Html::hiddenInput('oldAmphur', $model->amphur_id) . 
            
            '<label>' . $model->getAttributeLabel('tambol_id') . '</label>'.
            $form->field($model, 'tambol_id', [
                'options' => ['class' => 'form-group addr-tumbol'], 
                'inputOptions' => ['data-name' => 'tambol_id']
            ])->widget(Select2::classname(), WidgetSettings::Select2()) . 
                Html::hiddenInput('oldTambol', $model->tambol_id) . 
            '</div>';
        }
    ],/*[
        'attribute' => 'tambol_id',
        'label' => $model->getAttributeLabel('tambol_id'),
        'value' => $model->tambol_id,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'tambol_id', [
                'options' => ['class' => 'form-group addr-tumbol'], 
                'inputOptions' => ['data-name' => 'tambol_id']
            ])->widget(Select2::classname(), WidgetSettings::Select2()) . 
                Html::hiddenInput('oldTambol', $model->tambol_id);
        }
    ],[
        'attribute' => 'amphur_id',
        'label' => $model->getAttributeLabel('amphur_id'),
        'value' => $model->amphur_id,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'amphur_id', [
                'options' => ['class' => 'form-group addr-amphur'], 
                'inputOptions' => ['data-name' => 'amphur_id']
            ])->widget(Select2::classname(), WidgetSettings::Select2()) . 
                Html::hiddenInput('oldAmphur', $model->amphur_id);
        }
    ],[
        'attribute' => 'province_id',
        'label' => $model->getAttributeLabel('province_id'),
        'value' => $model->province_id,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'province_id', [
                'options' => ['class' => 'form-group addr-province'], 
                'inputOptions' => ['data-name' => 'province_id']
            ])->widget(Select2::classname(), WidgetSettings::Select2()) . 
                Html::hiddenInput('oldProvince', $model->province_id);
        }
    ],*/[
        'attribute' => 'postcode',
        'label' => $model->getAttributeLabel('postcode'),
        'value' => $model->postcode,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'postcode')->textInput()->label(false);
        }
    ],[
        'attribute' => 'phone',
        'label' => $model->getAttributeLabel('phone'),
        'value' => $model->phone,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'phone')->textInput()->label(false);
        }
    ],[
        'attribute' => 'fax',
        'label' => $model->getAttributeLabel('fax'),
        'value' => $model->fax,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'fax')->textInput()->label(false);
        }
    ],[
        'attribute' => 'move_in_date',
        'label' => $model->getAttributeLabel('move_in_date'),
        'value' => $model->move_in_date,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'move_in_date')->widget(DatePicker::className(), WidgetSettings::DatePicker());
        }
    ],[
        'attribute' => 'move_out_date',
        'label' => $model->getAttributeLabel('move_out_date'),
        'value' => $model->move_out_date,
        'updateMarkup' => function($form, $widget) use ($model) {
            return $form->field($model, 'move_out_date')->widget(DatePicker::className(), WidgetSettings::DatePicker());
        }
    ],[
        'attribute'=>'updated_at',
        'format'=>'raw',
        'value'=>'<span class="label label-primary">'.Yii::$app->formatter->asDateTime($model->updated_at).'</soan>',
        'displayOnly'=>true
    ],
];