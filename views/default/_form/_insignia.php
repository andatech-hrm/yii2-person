<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use andahrm\datepicker\DatePicker;
use kartik\widgets\Select2;
use andahrm\setting\models\WidgetSettings;
use andahrm\edoc\models\Edoc;
use andahrm\structure\models\Position;
use andahrm\structure\models\PositionOld;
use yii\bootstrap\ActiveForm;
use kartik\widgets\FileInput;
use yii\web\JsExpression;
/* @var $this yii\web\View */
use andahrm\structure\models\PersonType;
use andahrm\insignia\models\PersonInsignia;
use andahrm\insignia\models\InsigniaType;

if ($formAction == null) {
    $this->title = Yii::t('andahrm/person', 'Create Insignia New');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Person'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->fullname, 'url' => ['view', 'id' => $model->user_id]];
    $this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Prestige'), 'url' => ['view-prestige', 'id' => $model->user_id]];
//$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
    $this->params['breadcrumbs'][] = $this->title;
}

$modals['edoc'] = Modal::begin([
            'header' => Yii::t('andahrm/edoc', 'Create Edoc'),
            'size' => Modal::SIZE_LARGE
        ]);
// echo $this->render('@andahrm/edoc/views/default/_form', ['model' => new \andahrm\edoc\models\Edoc(), ]);
echo Yii::$app->runAction('/edoc/insignia/create-ajax', ['formAction' => Url::to(['/edoc/insignia/create-ajax'])]);
// echo '<iframe src="" frameborder="0" style="width:100%; height: 100%;" id="iframe_edoc_create"></iframe>';
Modal::end();
?>
<?php
$formOptions['options'] = ['data-pjax' => ''];
$formOptions['options'] = ['enctype' => 'multipart/form-data'];
if ($formAction !== null)
    $formOptions['action'] = $formAction;

$form = ActiveForm::begin($formOptions);
?>
<div class="insignias-form">

    <?php
    DynamicFormWidget::begin([
        'widgetContainer' => 'insignias_dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.insignias-container-items', // required: css class selector
        'widgetItem' => '.insignias-item', // required: css class
        'limit' => 4, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.insignias-add-item', // css class
        'deleteButton' => '.insignias-remove-item', // css class
        'model' => $models[0],
        'formId' => $form->id,
        'formFields' => [
            //'user_id',
            //'person_type_id',
            'year',
            //'gender',
            //'certificate_offer_name',
            'insignia_type_id',
            'last_position_id',
            //'last_salary',
            'edoc_id',
        ],
    ]);
    ?>

    <h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
        <span class="text-muted"><?= Yii::t('andahrm/person', 'Prestige') ?></span>
        <button type="button" class="pull-right insignias-add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= Yii::t('andahrm', 'Add List') ?></button>
    </h2> 

    <div class="insignias-container-items">
<?php foreach ($models as $index => $model): ?>
            <div class="insignias-item panel panel-default">
                <div class="panel-body" style="padding:8px;">

                    <button type="button" class="pull-right insignias-remove-item btn btn-danger btn-xs">
                        <i class="fa fa-minus"></i>
                    </button>
                    <h4 class="page-header green panel-title-insignias" style="margin-top: 0">
    <?= Yii::t('andahrm', 'List') ?>: <?= ($index + 1) ?>
                    </h4>
                    <div class="clearfix"></div>

                    <div class="row">
                        <?php #echo $form->errorSummary($model); ?>
                        <?php
                        if (!$model->isNewRecord) {
                            $form->field($model, "[{$index}]user_id")->hiddenInput()->label(false)->hint(false)->error(false);
                        }
                        ?>

                        <?=
                        $form->field($model, "[{$index}]last_position_id", [
                            'options' => ['class' => 'form-group  col-xs-3 col-sm-3'],
                        ])->widget(Select2::classname(), [
                            'data' => Position::myList($model->user_id),
                            'options' => ['placeholder' => Yii::t('andahrm/person', 'Search for a position')],
                                ]
                        )->hint(false);
                        ?>

    <?php
    /*
    echo  $form->field($model, "[{$index}]last_salary", [
        'options' => ['class' => 'form-group  col-xs-3 col-sm-3'],
    ])->textInput(['type' => 'number', 'min' => 0])
     * 
     */
    ?>





                        <?php /* = $form->field($model, "[{$index}]person_type_id",['options' => ['class' => 'form-group col-xs-3 col-sm-3 adjust_date']])
                          ->dropDownList(PersonType::getForInsignia(),[
                          'prompt'=>Yii::t('app','Select'),
                          //'id'=>'ddl-person_type'
                          ]) */ ?>

                        <?php
                        /*
                                $form->field($model, "[{$index}]year", ['options' => ['class' => 'form-group col-xs-3 col-sm-3 adjust_date']])
                                ->widget(DatePicker::classname(), [
                                    'options' => [
                                        'daysOfWeekDisabled' => [0, 6],
                                    ],
                        ]);
                         * 
                         */
                        ?>

                        <?php /* =$form->field($model,"[{$index}]gender",[
                          'options' => ['class' => 'form-group  col-xs-3 col-sm-3'],
                          ])->dropDownList(PersonInsignia::getGenders(),['prompt'=>Yii::t('app','Select')]) */ ?>


    <?=
    $form->field($model, "[{$index}]insignia_type_id", [
        'options' => ['class' => 'form-group  col-xs-3 col-sm-3'],
    ])->dropDownList(InsigniaType::getList())
    ?>

                   

                        


                        <?php
$toEdocCreate = Url::to(['/edoc/default/create']);
if($formAction){
$edocInputTemplate = <<< HTML
<div class="input-group">
    {input}
   <span class="input-group-addon btn btn-success btn-create-edoc" >
    <a href="{$toEdocCreate}" target="_bank">
        <i class="fa fa-plus"></i>
    </a>
    </span>
</div>
HTML;
}else{
$edocInputTemplate = <<< HTML
<div class="input-group">
    {input}
   <span class="input-group-addon btn btn-success btn-create-edoc"  role="edoc" data-toggle="modal" data-target="#{$modals['edoc']->id}">
        <i class="fa fa-plus"></i>
    </span>
</div>
HTML;
}
?>
                         <?=$form->field($model, "[{$index}]edoc_id",[
                             'inputTemplate' => $edocInputTemplate,
                             'options' => ['class' => 'form-group  col-xs-4 col-sm-4'
                             ]])
                         ->widget(Select2::className(),
                         [
                                    'data' => Edoc::getList(),
                                    'options' => ['placeholder' => Yii::t('andahrm/person', 'Search for a edoc')],
                                    'pluginOptions' => [
                                        //'tags' => true,
                                        //'tokenSeparators' => [',', ' '],
                                        'allowClear'=>true,
                                        'minimumInputLength'=>2,//ต้องพิมพ์อย่างน้อย 3 อักษร ajax จึงจะทำงาน
                                        'ajax'=>[
                                            'url'=>Url::to(['/edoc/insignia/get-list']),
                                            'dataType'=>'json',//รูปแบบการอ่านคือ json
                                            'data'=>new JsExpression('function(params) { return {q:params.term};}')
                                         ],
                                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                        'templateResult' => new JsExpression('function(position) { return position.text; }'),
                                        'templateSelection' => new JsExpression('function (position) { return position.text; }'),
                                    ],
                                ]
                         
                         );
                        ?>
                    </div>

                </div>
            </div>
<?php endforeach; ?>
    </div>
<?php DynamicFormWidget::end(); ?>

    <div class="form-group">
<?= Html::submitButton(Yii::t('andahrm', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
<?php
$this->registerJs("
function initSelect2Loading(a,b){ initS2Loading(a,b); }
function initSelect2DropStyle(id, kvClose, ev){ initS2Open(id, kvClose, ev); }", $this::POS_HEAD);


$listLabel = Yii::t('andahrm', 'List');
$js[] = <<< JS
bindBtnAddEdoc();
jQuery(".insignias_dynamicform_wrapper").on('afterInsert', function(e, item) {  
    $(".insignias_dynamicform_wrapper .panel-title-positions").each(function(index) {
        jQuery(this).html("{$listLabel}: " + (index + 1));
    });    
    bindBtnAddEdoc();    
});

jQuery(".insignias_dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".insignias_dynamicform_wrapper .panel-title-positions").each(function(index) {
        jQuery(this).html("{$listLabel}: " + (index + 1));
    });
    bindBtnAddEdoc();
});


var input_edoc = '';
function bindBtnAddEdoc(){
    $(".insignias_dynamicform_wrapper .btn-create-edoc").each(function(index) {
        $(this).unbind("click");
        $(this).bind("click",function(){
            $(this).attr('data-key',index);
            input_edoc = $(this).attr('data-key');
            //alert(input_edoc);
        });
    });        
}
JS;
$this->registerJs(implode("\n", $js), $this::POS_END);



$jsHead[] = <<< JS
function callbackEdoc(result,form)
{   
    $("#insigniaperson-"+input_edoc+"-edoc_id").append($('<option>', {
        value: result.id,
        text: result.code + ' ' + result.date_code + ' ' + result.title
    }));
    $("#insigniaperson-"+input_edoc+"-edoc_id").val(result.id).trigger('change.select2');
    
    $("#{$modals['edoc']->id}").modal('hide');
    $(form).trigger("reset");
}
JS;

$this->registerJs(implode("\n", $jsHead), $this::POS_HEAD);

///Surakit
if ($formAction !== null) {
    $js[] = <<< JS
$(document).on('submit', '#{$form->id}', function(e){
  e.preventDefault();
  var form = $(this);
  var formData = new FormData(form[0]);
  // alert(form.serialize());
  
  $.ajax({
    url: form.attr('action'),
    type : 'POST',
    data: formData,
    contentType:false,
    cache: false,
    processData:false,
    dataType: "json",
    success: function(data) {
      if(data.success){
        callbackPosition(data.result);
      }else{
        alert('Fail');
      }
    }
  });
});
JS;

    $this->registerJs(implode("\n", $js));
}
?>