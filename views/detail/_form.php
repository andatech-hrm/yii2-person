<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use andahrm\person\models\Nationality;
use andahrm\person\models\Race;
use andahrm\person\models\Religion;

use andahrm\setting\models\LocalRegion;
use andahrm\setting\models\LocalProvince;
use andahrm\setting\models\LocalAmphur;
use andahrm\setting\models\LocalTumbol;
use andahrm\setting\models\WidgetSettings;

use kartik\widgets\Select2;
use andahrm\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Detail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detail-form">

    <?php if($form === null) { $form = ActiveForm::begin(); $isRenderPartial = false; }else{ $isRenderPartial = true; } ?>

	<?php if(!$isRenderPartial) { ?>
    <div class="pull-right">
    <?= Html::a('<i class="fa fa-times"></i> Discard', array_merge(['view'], Yii::$app->request->getQueryParams()), ['class' => 'btn btn-default']) ?>
    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check"></i> '.Yii::t('andahrm', 'Create') : '<i class="fa fa-check"></i> '.Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <h4><?= $model->isNewRecord ? Yii::t('andahrm', 'Create Person Detail') : $model->person->fullname; ?></h4>
    <hr>
	<?php } ?>
	
	<div class="x_panel">
		<div class="x_title">
			<h2>Detail</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
            
			<?= Html::activeHiddenInput($model, 'user_id'); ?>
			<div class="row">
			<?= $form->field($model, 'nationality_id', ['options' => ['class' => 'form-group col-sm-6']])->widget(Select2::classname(), array_replace_recursive(WidgetSettings::Select2(), [
				'data' => ArrayHelper::map(Nationality::find()->all(), 'id', 'title'),
			])) ?>

			<?= $form->field($model, 'race_id', ['options' => ['class' => 'form-group col-sm-6']])->widget(Select2::classname(), array_replace_recursive(WidgetSettings::Select2(), [
				'data' => ArrayHelper::map(Race::find()->all(), 'id', 'title'),
			])) ?>
			</div>
			
			<div class="row">
			<?= $form->field($model, 'religion_id', ['options' => ['class' => 'form-group col-sm-6']])->inline()->radioList(ArrayHelper::map(Religion::find()->all(), 'id', 'title')) ?>

			<?= $form->field($model, 'blood_group', ['options' => ['class' => 'form-group col-sm-6']])->inline()->radioList($model->getBloodGroups()) ?>
			</div>

			<div class="row">
			<?= $form->field($model, 'father_name', ['options' => ['class' => 'form-group col-sm-6']])->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'mother_name', ['options' => ['class' => 'form-group col-sm-6']])->textInput(['maxlength' => true]) ?>
			</div>
			
			<div class="row">
			<?= $form->field($model, 'married_status', ['options' => ['class' => 'form-group col-sm-6']])->inline()->radioList($model->getStatuses()) ?>

			<?= $form->field($model, 'people_spouse_id', ['options' => ['class' => 'form-group col-sm-6']])->textInput() ?>
			</div>
			
			<div class="row">
				<h4 class="page-header">Address</h4>
				<?php
				$addresses = [
					'address_contact_id' => $modelAddressContact,
					'address_birth_place_id' => $modelAddressBirthPlace,
					'address_register_id' => $modelAddressRegister,
				];
				$localRegion = ArrayHelper::map(LocalRegion::find()->all(), 'id', 'name');
				?>
				<?php 
				$loop = 0;
				foreach($addresses as $key => $address) : 
				$loop++;
				?>
				<div class="col-sm-4 address-pane">
					<p class="lead green"><?= $model->getAttributeLabel($key); ?></p>
					<label>Copy from</label><br />
					<div class="btn-group" role="group" aria-label="...">
						<?= ($key !== 'address_contact_id') ? Html::button($model->getAttributeLabel('address_contact_id'), ['class' => 'btn btn-default btn-copy', 'data-from' => 'tab_address_contact_id']) : ''; ?>
						<?= ($key !== 'address_birth_place_id') ? Html::button($model->getAttributeLabel('address_birth_place_id'), ['class' => 'btn btn-default btn-copy', 'data-from' => 'tab_address_birth_place_id']) : ''; ?>
						<?= ($key !== 'address_register_id') ? Html::button($model->getAttributeLabel('address_register_id'), ['class' => 'btn btn-default btn-copy', 'data-from' => 'tab_address_register_id']) : ''; ?>
					</div>
					<div class="clearfix"></div><br />
					<?= $form->field($address, 'number_registration', ['inputOptions' => ['data-name' => 'number_registration']])->textInput() ?>

					<?= $form->field($address, 'number', ['inputOptions' => ['data-name' => 'number']])->textInput() ?>

					<?= $form->field($address, 'sub_road', ['inputOptions' => ['data-name' => 'sub_road']])->textInput() ?>

					<?= $form->field($address, 'road', ['inputOptions' => ['data-name' => 'road']])->textInput() ?>

					<?= $form->field($address, 'localRegion')->inline()->radioList($localRegion, ['data-province-json' => Url::to(['/setting/local-province/json']), 'class' => 'local-region']) ?>

					<?= $form->field($address, 'province_id', ['options' => ['class' => 'form-group addr-province'], 'inputOptions' => ['data-name' => 'province_id']])->widget(Select2::classname(), WidgetSettings::Select2()) ?>
					<?= Html::hiddenInput('oldProvince', $address->province_id); ?>

					<?= $form->field($address, 'amphur_id', ['options' => ['class' => 'form-group addr-amphur'], 'inputOptions' => ['data-name' => 'amphur_id']])->widget(Select2::classname(), WidgetSettings::Select2()) ?>
					<?= Html::hiddenInput('oldAmphur', $address->amphur_id); ?>

					<?= $form->field($address, 'tambol_id', ['options' => ['class' => 'form-group addr-tumbol'], 'inputOptions' => ['data-name' => 'tambol_id']])->widget(Select2::classname(), WidgetSettings::Select2()) ?>
					<?= Html::hiddenInput('oldTambol', $address->tambol_id); ?>

					<?= $form->field($address, 'postcode', ['inputOptions' => ['data-name' => 'postcode']])->textInput() ?>

					<?= $form->field($address, 'phone', ['inputOptions' => ['data-name' => 'phone']])->textInput() ?>

					<?= $form->field($address, 'fax', ['inputOptions' => ['data-name' => 'fax']])->textInput() ?>

					<?= $form->field($address, 'move_in_date', ['inputOptions' => ['data-name' => 'move_in_date']])->widget(DatePicker::classname(), WidgetSettings::DatePicker()) ?>

					<?= $form->field($address, 'move_out_date', ['inputOptions' => ['data-name' => 'move_out_date']])->widget(DatePicker::classname(), WidgetSettings::DatePicker()) ?>
				</div>
				<?php endforeach; ?>
			</div>

		</div>
	</div>
    
    
    


    <hr />

	<?php if(!$isRenderPartial) { ?>
    <div class="form-group pull-right">
        <?= Html::a('<i class="fa fa-times"></i> Discard', array_merge(['view'], Yii::$app->request->getQueryParams()), ['class' => 'btn btn-default']) ?>
    	<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check"></i> '.Yii::t('andahrm', 'Create') : '<i class="fa fa-check"></i> '.Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	<?php } ?>

    <?php if(!$isRenderPartial) { ActiveForm::end(); } ?>
</div>


<?php
$inputRegoinContactName = $modelAddressContact->formName().'[localRegion]';
$inputRegoinBirthPlaceName = $modelAddressBirthPlace->formName().'[localRegion]';
$inputRegoinRegisterName = $modelAddressRegister->formName().'[localRegion]';

$js[] = <<< JS
//$(document).on('change', 'input:radio[name="{$inputRegoinContactName}"], input:radio[name="{$inputRegoinBirthPlaceName}"], input:radio[name="{$inputRegoinRegisterName}"]', function(e){
$(document).on('change', '.address-pane .local-region input:radio', function(e){
    var input = $(this);
    var tabPane = input.closest('div.address-pane');
    var inputProvince = tabPane.find('div.addr-province select');
    var inputAmphur = tabPane.find('div.addr-amphur select');
    var inputTumbol = tabPane.find('div.addr-tumbol select');
    var oldProvince = input.closest('.address-pane').find('input[name="oldProvince"]');
    var selected = '';
    $.ajax({
        url: input.closest('.local-region').data('province-json'),
        data: {'region_id': input.val() },
        dataType: 'json',
        success: function(data){
            inputProvince.text("");
            inputAmphur.text("");
            inputTumbol.text("");
            $.each(data, function( index, value ) {
                selected = '';
                if (oldProvince.val() == index) {
                    selected = ' selected';
                }
			    inputProvince.append("<option value='" + index + "'" + selected + "> " + value + "</option>");
			});
            inputProvince.trigger('change');
        }
    });
});
JS;

$jsonUrl['amphur'] = Url::to(['/setting/local-amphur/json']);
$js[] = <<< JS
$(document).on('change', '.address-pane .addr-province select', function(e){
    var input = $(this);
    var tabPane = input.closest('div.address-pane');
    var inputProvince = tabPane.find('div.addr-province select');
    var inputAmphur = tabPane.find('div.addr-amphur select');
    var inputTumbol = tabPane.find('div.addr-tumbol select');
    var oldAmphur = input.closest('.address-pane').find('input[name="oldAmphur"]');
    var selected = '';
    $.ajax({
        url: "{$jsonUrl['amphur']}",
        data: {'province_id': input.val() },
        dataType: 'json',
        success: function(data){
            inputAmphur.text("");
            inputTumbol.text("");
            $.each(data, function( index, value ) {
                selected = '';
                if (oldAmphur.val() == index) {
                    selected = ' selected';
                }
			    inputAmphur.append("<option value='" + index + "'" + selected + "> " + value + "</option>");
			});
            inputAmphur.trigger('change');
        }
    });
})
JS;

$jsonUrl['tambol'] = Url::to(['/setting/local-tambol/json']);
$js[] = <<< JS
$(document).on('change', '.address-pane .addr-amphur select', function(e){
    var input = $(this);
    var tabPane = input.closest('div.address-pane');
    var inputProvince = tabPane.find('div.addr-province select');
    var inputAmphur = tabPane.find('div.addr-amphur select');
    var inputTumbol = tabPane.find('div.addr-tumbol select');
    var oldTambol = input.closest('.address-pane').find('input[name="oldTambol"]');
    var selected = '';
    $.ajax({
        url: "{$jsonUrl['tambol']}",
        data: {'amphur_id': input.val() },
        dataType: 'json',
        success: function(data){
            inputTumbol.text("");
            $.each(data, function( index, value ) {
                selected = '';
                if (oldTambol.val() == index) {
                    selected = ' selected';
                }
			    inputTumbol.append("<option value='" + index + "'" + selected + "> " + value + "</option>");
			});
        }
    });
})
JS;

$js[] = <<< JS
$('.address-pane .local-region input:radio[checked]').trigger('change');
JS;


$js[] = <<< JS
$(document).on('click', '.btn-copy', function(e){
    e.preventDefault();
    var tabThis = $(this).closest('.tab-pane');
    var inputsThis = tabThis.find(':input').not('.btn-copy');
    var tabFrom = $('#' + $(this).data('from'));
    var inputsFrom = tabFrom.find(':input').not('.btn-copy');
    $.each(inputsThis, function(k, item){
        var attr = $(this).attr('data-name');
        if (typeof attr !== typeof undefined && attr !== false) {
        var name = $(this).data('name');
        var value = tabFrom.find(':input[data-name="' + name + '"]').val();
        $(this).val(value);
         console.log(tabFrom.find(':input[data-name="' + name + '"]').val());
        }
    });
});
JS;


$this->registerJs(implode("\n", $js));
