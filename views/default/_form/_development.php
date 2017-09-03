<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use andahrm\datepicker\DatePicker;
use kartik\widgets\Select2;
use andahrm\setting\models\WidgetSettings;
use yii\bootstrap\ActiveForm;
use kartik\widgets\FileInput;
use yii\web\JsExpression;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */


use andahrm\development\models\DevelopmentPerson;
use andahrm\development\models\DevelopmentProject;
use andahrm\development\models\DevelopmentActivityChar;

if($formAction == null){
    $this->title = Yii::t('andahrm/person', 'Create Development New');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Person'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->fullname, 'url' => ['view', 'id' => $model->user_id]];
    $this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Position'), 'url' => ['view-position', 'id' => $model->user_id]];
    //$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
    $this->params['breadcrumbs'][] = $this->title;
}


$modals['project'] = Modal::begin([
    'header' => Yii::t('andahrm/structure', 'Create Position'),
    'size' => Modal::SIZE_LARGE
]);
echo Yii::$app->runAction('/development/project/create-ajax', ['formAction' => Url::to(['/development/project/create-ajax'])]);
Modal::end();
    






  $formOptions['options'] = ['data-pjax' => ''];
  //$formOptions['options'] = ['enctype' => 'multipart/form-data'];
  if($formAction !== null)  $formOptions['action'] = $formAction;
  
  $form = ActiveForm::begin($formOptions); 
  ?>
<div class="insignias-form">

    <?php DynamicFormWidget::begin([
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
            'dev_project_id',
            'dev_activity_char_id',
        ],
    ]); ?>
    
    <h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
        <span class="text-muted"><?=Yii::t('andahrm/person', 'Position History')?></span>
        <button type="button" class="pull-right insignias-add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> <?=Yii::t('andahrm', 'Add List')?></button>
    </h2> 
    
        <div class="insignias-container-items">
            <?php foreach ($models as $index => $model): ?>
            <div class="insignias-item panel panel-default">
                <div class="panel-body" style="padding:8px;">
                    
                    <button type="button" class="pull-right insignias-remove-item btn btn-danger btn-xs">
                        <i class="fa fa-minus"></i>
                    </button>
                    <h4 class="page-header green panel-title-insignias" style="margin-top: 0">
                        <?=Yii::t('andahrm', 'List')?>: <?= ($index + 1) ?>
                    </h4>
                    <div class="clearfix"></div>
                    
                   <div class="row">
                       <?php #echo $form->errorSummary($model); ?>
                        
<?php                        
$edocInputTemplate = <<< HTML
<div class="input-group">
    {input}
    <span class="input-group-addon btn btn-success btn-create-project" data-key="{$index}" role="position" data-toggle="modal" data-target="#{$modals['project']->id}">
        <i class="fa fa-plus"></i>
    </span>
</div>
HTML;
?>                    
                        
                        
            <?= $form->field($model, "[{$index}]dev_project_id",[
                'inputTemplate' => $edocInputTemplate,
                'options' => ['class' => 'form-group  col-xs-6 col-sm-6'],
            ])->widget(Select2::classname(),
                                [
                                    'data' => DevelopmentProject::getList(),
                                    'options' => ['placeholder' => Yii::t('andahrm/development', 'Search for a project')],
                                    'pluginOptions' => [
                                        //'tags' => true,
                                        //'tokenSeparators' => [',', ' '],
                                        'allowClear'=>true,
                                        'minimumInputLength'=>2,//ต้องพิมพ์อย่างน้อย 3 อักษร ajax จึงจะทำงาน
                                        'ajax'=>[
                                            'url'=>Url::to(['/development/project/get-list']),
                                            'dataType'=>'json',//รูปแบบการอ่านคือ json
                                            'data'=>new JsExpression('function(params) { return {q:params.term};}')
                                         ],
                                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                        'templateResult' => new JsExpression('function(position) { return position.text; }'),
                                        'templateSelection' => new JsExpression('function (position) { return position.text; }'),
                                    ],
                                ]
                            )->hint(false);
                            ?>
            
            <?php /*= $form->field($model, "[{$index}]dev_activity_char_id",[
                            'options' => ['class' => 'form-group  col-xs-3 col-sm-3'],
                        ])->widget(Select2::className(), [
                'data' => DevelopmentActivityChar::getList(),
                'options' => [
                    'placeholder' => 'เลือก..',
                'multiple' => true
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->hint(false);*/
            ?>
            
            <?= $form->field($model, "[{$index}]dev_activity_char_id",[
                            'options' => ['class' => 'form-group  col-xs-3 col-sm-3'],
                        ])->dropDownList( DevelopmentActivityChar::getList(),
                [
                    'placeholder' => 'เลือก..',
                    'multiple' => true
            ])->hint(false);
            ?>
                </div>

    
                        
                    
                    
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php DynamicFormWidget::end(); ?>
    
     <div class="form-group">
         <?= Html::submitButton( Yii::t('andahrm', 'Save') , ['class' =>  'btn btn-success' ]) ?>
    </div>
</div>

    <?php ActiveForm::end();  ?>
    
    
    
    
    
<?php
$this->registerJs("
function initSelect2Loading(a,b){ initS2Loading(a,b); }
function initSelect2DropStyle(id, kvClose, ev){ initS2Open(id, kvClose, ev); }
", 
$this::POS_HEAD);


$listLabel = Yii::t('andahrm', 'List');
$js[] = <<< JS

bindBtnAddProject();
jQuery(".insignias_dynamicform_wrapper").on('afterInsert', function(e, item) {

    $(".insignias_dynamicform_wrapper .panel-title-insignias").each(function(index) {
        jQuery(this).html("{$listLabel}: " + (index + 1));
    });
    bindBtnAddProject();
});

jQuery(".insignias_dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".insignias_dynamicform_wrapper .panel-title-insignias").each(function(index) {
        jQuery(this).html("{$listLabel}: " + (index + 1));
    });
    bindBtnAddProject();
});

var input_project = '';
function bindBtnAddProject(){
    $(".insignias_dynamicform_wrapper .btn-create-project").each(function(index) {
        $(this).unbind("click");
        $(this).bind("click",function(){
            $(this).attr('data-key',index);
            input_project = $(this).attr('data-key');
            console.log(input_project);
        });
    });
}

JS;
    
$this->registerJs(implode("\n", $js), $this::POS_END);

$jsHead[] = <<< JS
function callbackProject(result,form)
{   console.log(result);
    $("#developmentperson-"+input_project+"-dev_project_id").append($('<option>', {
        value: result.id,
        text: result.title
    }));
    $("#developmentperson-"+input_project+"-dev_project_id").val(result.id).trigger('change.select2');
    
    $("#{$modals['project']->id}").modal('hide');
    //alert(form);
    $(form).trigger("reset");
}
JS;

$this->registerJs(implode("\n", $jsHead), $this::POS_HEAD);