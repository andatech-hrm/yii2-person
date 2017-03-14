<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kuakling\datepicker\DatePicker;
use kartik\widgets\Select2;
use andahrm\setting\models\WidgetSettings;

/* @var $this yii\web\View */
/* @var $modelCustomer app\modules\yii2extensions\models\Customer */
/* @var $modelsAddress app\modules\yii2extensions\models\Address */


$this->context->prepareData();
?>

<div class="childs-form">

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 4, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $models[0],
        'formId' => $form->id,
        'formFields' => [
            'citizen_id',
            'name',
            'surname',
            'birthday',
            'nationality_id',
            'race_id',
            'occupation',
            'live_status',
        ],
    ]); ?>    
    <div class="x_panel">
        <div class="x_title">
            <h2>Child</h2>
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add child</button>
            <div class="clearfix"></div>
        </div>
        <div class="x_content container-items">
            <?php foreach ($models as $index => $model): ?>
            <div class="item panel panel-default">
                <div class="panel-body"><button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                    <h4 class="page-header green panel-title-address" style="margin-top: 0">
                        Child: <?= ($index + 1) ?>
                        
                    </h4>
                    <div class="clearfix"></div>
                    <?php
                    // necessary for update action.
                    if (!$model->isNewRecord) {
                        echo Html::activeHiddenInput($model, "[{$index}]id");
                    }
                    ?>
                   <div class="row">
                        <?= $form->field($model, "[{$index}]citizen_id", ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, "[{$index}]name", ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, "[{$index}]surname", ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, "[{$index}]birthday", ['options' => ['class' => 'form-group col-sm-3']])->widget(DatePicker::className(), WidgetSettings::DatePicker()) ?>
                    </div><!-- end:row -->

                    <div class="row">
                        <?= $form->field($model, "[{$index}]nationality_id", ['options' => ['class' => 'form-group col-sm-3']])->widget(Select2::classname(), WidgetSettings::Select2([
                            'data' => ArrayHelper::map($this->context->nationalities, 'id', 'title')
                        ]))?>

                        <?= $form->field($model, "[{$index}]race_id", ['options' => ['class' => 'form-group col-sm-3']])->widget(Select2::classname(), WidgetSettings::Select2([
                            'data' => ArrayHelper::map($this->context->races, 'id', 'title')
                        ]))?>

                        <?= $form->field($model, "[{$index}]occupation", ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, "[{$index}]live_status", ['options' => ['class' => 'form-group col-sm-3']])->inline()->radioList($model->getLiveStatuses()) ?>
                    </div><!-- end:row -->
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php DynamicFormWidget::end(); ?>
</div>
<?php
$this->registerJs("
function initSelect2Loading(a,b){ initS2Loading(a,b); }
function initSelect2DropStyle(id, kvClose, ev){ initS2Open(id, kvClose, ev); }", 
$this::POS_HEAD);

$js[] = <<< JS
jQuery(".dynamicform_wrapper").on('afterInsert', function(e, item) {
    var datePickers = $(this).find('[data-krajee-kvdatepicker]');
    datePickers.each(function(index, el) {
        $(this).parent().removeData().kvDatepicker('remove');
        $(this).parent().kvDatepicker(eval($(this).attr('data-krajee-kvdatepicker')));
    });
    
    $(item).find('.nationality select').val({$this->context->defaultNationalityId}).trigger("change");
    $(item).find('.race select').val({$this->context->defaultRaceId}).trigger("change");
    
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Child: " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Child: " + (index + 1))
    });
});
JS;
    
$this->registerJs(implode("\n", $js));