<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kuakling\datepicker\DatePicker;
use kartik\widgets\Select2;
use andahrm\setting\models\WidgetSettings;

/* @var $this yii\web\View */

?>

<div class="educations-form">

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'educations_dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.educations-container-items', // required: css class selector
        'widgetItem' => '.educations-item', // required: css class
        'limit' => 4, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.educations-add-item', // css class
        'deleteButton' => '.educations-remove-item', // css class
        'model' => $models[0],
        'formId' => $form->id,
        'formFields' => [
            'year_start',
            'year_end',
            'level_id',
            'degree',
            'branch',
            'institution',
            'country_id',
        ],
    ]); ?>
    
    <h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
        <i class="<?= $this->context->formSteps[2]['icon']; ?>"></i> Step 2 
        <span class="text-muted"><?= $this->context->formSteps[2]['desc']; ?></span>
        <button type="button" class="pull-right educations-add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add Education</button>
        <!--<div class="clearfix"></div>-->
    </h2>
        <div class="educations-container-items">
            <?php foreach ($models as $index => $model): ?>
            <div class="educations-item panel panel-default">
                <div class="panel-body"><button type="button" class="pull-right educations-remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                    <h4 class="page-header green panel-title-educations" style="margin-top: 0">
                        Education: <?= ($index + 1) ?>
                        
                    </h4>
                    <div class="clearfix"></div>
                    <?php
                    // necessary for update action.
                    if (!$model->isNewRecord) {
                        echo Html::activeHiddenInput($model, "[{$index}]id");
                    }
                    ?>
                   <div class="row">
                        <?= $form->field($model, "[{$index}]year_start", ['options' => ['class' => 'form-group col-sm-2']])->widget(\kuakling\datepicker\YearBuddhist::className()) ?>
                        <?= $form->field($model, "[{$index}]year_end", ['options' => ['class' => 'form-group col-sm-2']])->widget(\kuakling\datepicker\YearBuddhist::className()) ?>
                        <?= $form->field($model, "[{$index}]level_id", ['options' => ['class' => 'form-group col-sm-3']])->dropDownList(ArrayHelper::map($this->context->educationLevels, 'id', 'title')) ?>
                        <?= $form->field($model, "[{$index}]degree", ['options' => ['class' => 'form-group col-sm-2']])->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, "[{$index}]branch", ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
                    </div><!-- end:row -->

                    <div class="row">

                        <?= $form->field($model, "[{$index}]institution", ['options' => ['class' => 'form-group col-sm-4']])->textInput(['maxlength' => true]) ?>
                        
                        <?= $form->field($model, "[{$index}]province", ['options' => ['class' => 'form-group col-sm-4']])->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, "[{$index}]country_id", ['options' => ['class' => 'form-group col-sm-4 country']])->widget(Select2::classname(), WidgetSettings::Select2([
                            'data' => ArrayHelper::map($this->context->countries, 'id', 'title')
                        ])) ?>

                    </div><!-- end:row -->
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php DynamicFormWidget::end(); ?>
</div>
<?php
$this->registerJs("
function initSelect2Loading(a,b){ initS2Loading(a,b); }
function initSelect2DropStyle(id, kvClose, ev){ initS2Open(id, kvClose, ev); }", 
$this::POS_HEAD);

$js[] = <<< JS
jQuery(".educations_dynamicform_wrapper").on('afterInsert', function(e, item) {
    $(item).find('.country select').val({$this->context->defaultCountryId}).trigger("change");
    jQuery(".educations_dynamicform_wrapper .panel-title-educations").each(function(index) {
        jQuery(this).html("Education: " + (index + 1))
    });
});

jQuery(".educations_dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".educations_dynamicform_wrapper .panel-title-educations").each(function(index) {
        jQuery(this).html("Education: " + (index + 1))
    });
});
JS;
    
$this->registerJs(implode("\n", $js));