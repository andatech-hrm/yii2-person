<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kuakling\datepicker\DatePicker;
use kartik\widgets\Select2;
use andahrm\setting\models\WidgetSettings;

/* @var $this yii\web\View */
/* @var $modelCustomer app\modules\yii2extensions\models\Customer */
/* @var $modelsAddress app\modules\yii2extensions\models\Address */

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Child: " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Child: " + (index + 1))
    });
});
';

$this->registerJs($js);

$this->context->prepareData();
?>

<div class="childs-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 4, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsPeople[0],
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
    <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add address</button>
            <div class="clearfix"></div>
    <div class="container-items">
        <?php foreach ($modelsPeople as $index => $modelPeople): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <span class="panel-title-address">Child: <?= ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (!$modelPeople->isNewRecord) {
                                echo Html::activeHiddenInput($modelPeople, "[{$index}]id");
                            }
                        ?>

                        <div class="row">
                            <?= $form->field($modelPeople, "[{$index}]citizen_id", ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
                            <?= $form->field($modelPeople, "[{$index}]name", ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
                            <?= $form->field($modelPeople, "[{$index}]surname", ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
                            <?= $form->field($modelPeople, "[{$index}]birthday", ['options' => ['class' => 'form-group col-sm-3']])->widget(DatePicker::className(), WidgetSettings::DatePicker()) ?>
                        </div><!-- end:row -->

                        <div class="row">
                            <?= $form->field($modelPeople, "[{$index}]nationality_id", ['options' => ['class' => 'form-group col-sm-3']])->widget(Select2::classname(), WidgetSettings::Select2([
                                'data' => ArrayHelper::map($this->context->nationalities, 'id', 'title')
                            ]))?>
                            <?= $form->field($modelPeople, "[{$index}]race_id", ['options' => ['class' => 'form-group col-sm-3']])->widget(Select2::classname(), WidgetSettings::Select2([
                                'data' => ArrayHelper::map($this->context->races, 'id', 'title')
                            ]))?>
                            <?= $form->field($modelPeople, "[{$index}]occupation", ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
                            <?= $form->field($modelPeople, "[{$index}]live_status", ['options' => ['class' => 'form-group col-sm-3']])->inline()->radioList($modelPeople->getLiveStatuses()) ?>
                        </div><!-- end:row -->
                    </div>
                </div>
            <?php endforeach; ?>
    </div>
    <?php DynamicFormWidget::end(); ?>
    
    <div class="form-group">
        <?= Html::submitButton($modelPeople->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>

    
</div>
<?php
$this->registerJs("
function initSelect2Loading(a,b){ initS2Loading(a,b); }
function initSelect2DropStyle(id, kvClose, ev){ initS2Open(id, kvClose, ev); }", $this::POS_HEAD);

$this->registerJs("
$(\".dynamicform_wrapper\").on('afterInsert', function(e, item) {
    var datePickers = $(this).find('[data-krajee-kvdatepicker]');
    datePickers.each(function(index, el) {
        $(this).parent().removeData().kvDatepicker('remove');
        $(this).parent().kvDatepicker(eval($(this).attr('data-krajee-kvdatepicker')));
    });
});
");