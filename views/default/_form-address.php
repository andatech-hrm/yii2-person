<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use andahrm\setting\models\LocalRegion;


use andahrm\setting\models\WidgetSettings;

use kartik\widgets\Select2;
use andahrm\datepicker\DatePicker;
?>
<?php $model->localRegion = ($model->province !== null) ? $model->province->region_id : null; ?>
<div class="address-pane">
    <div class="row">
<?php #echo $form->field($model, 'type')->textInput() ?>        
        
<?= $form->field($model, 'number_registration', [
    'options' => ['class' => 'form-group col-sm-3'],
    'inputOptions' => ['data-name' => 'number_registration']
])->textInput() ?>

<?= $form->field($model, 'number', [
    'options' => ['class' => 'form-group col-sm-3'],
    'inputOptions' => ['data-name' => 'number']])->textInput() 
?>

<?= $form->field($model, 'sub_road', [
    'options' => ['class' => 'form-group col-sm-3'],
    'inputOptions' => ['data-name' => 'sub_road']])->textInput() 
?>

<?= $form->field($model, 'road', [
    'options' => ['class' => 'form-group col-sm-3'],
    'inputOptions' => ['data-name' => 'road']])->textInput() 
?>
    </div>
    
    <?= $form->field($model, 'localRegion')->inline()->radioList(
        ArrayHelper::map(LocalRegion::find()->all(), 'id', 'name'), 
        [
            // 'itemOptions' => ['data-name' => 'local-region'],
            
            'item' => function($index, $label, $name, $checked, $value) {
                return Html::radio($name, $checked, [
                    'value' => $value,
                    'label' => Html::encode($label),
                    'data-name' => 'local-region-'.$index,
                ]);
            },
            'data-province-json' => Url::to(['/setting/local-province/json']), 
            'class' => 'local-region'
        ]
    ) ?>
    
    <div class="row">

<?= $form->field($model, 'province_id', ['options' => ['class' => 'form-group col-sm-3 addr-province'], 'inputOptions' => ['data-name' => 'province_id']])->widget(Select2::classname(), WidgetSettings::Select2()) ?>
<?= Html::hiddenInput('oldProvince', $model->province_id); ?>

<?= $form->field($model, 'amphur_id', ['options' => ['class' => 'form-group col-sm-3 addr-amphur'], 'inputOptions' => ['data-name' => 'amphur_id']])->widget(Select2::classname(), WidgetSettings::Select2()) ?>
<?= Html::hiddenInput('oldAmphur', $model->amphur_id); ?>

<?= $form->field($model, 'tambol_id', ['options' => ['class' => 'form-group col-sm-3 addr-tumbol'], 'inputOptions' => ['data-name' => 'tambol_id']])->widget(Select2::classname(), WidgetSettings::Select2()) ?>
<?= Html::hiddenInput('oldTambol', $model->tambol_id); ?>

<?= $form->field($model, 'postcode', ['options' => ['class' => 'form-group col-sm-3'], 'inputOptions' => ['data-name' => 'postcode']])->textInput() ?>
    </div>
    
    <div class="row">

<?= $form->field($model, 'phone', ['options' => ['class' => 'form-group col-sm-3'], 'inputOptions' => ['data-name' => 'phone']])->textInput() ?>

<?= $form->field($model, 'fax', ['options' => ['class' => 'form-group col-sm-3'], 'inputOptions' => ['data-name' => 'fax']])->textInput() ?>

<?= $form->field($model, 'move_in_date', ['options' => ['class' => 'form-group col-sm-3']])->widget(DatePicker::classname(), WidgetSettings::DatePicker([
    'options' => ['data-name' => 'move_in_date']
])) ?>

<?= $form->field($model, 'move_out_date', ['options' => ['class' => 'form-group col-sm-3']])->widget(DatePicker::classname(), WidgetSettings::DatePicker([
    'options' => ['data-name' => 'move_out_date']
])) ?>
    </div>
</div>