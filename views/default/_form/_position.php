<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
use kartik\widgets\Typeahead;
use yii\web\JsExpression;

use andahrm\structure\models\PositionType;
use andahrm\structure\models\PositionLevel;
use andahrm\positionSalary\models\PersonPositionSalary;
use kartik\widgets\DepDrop;

use yii\bootstrap\Modal;
/* @var $this yii\web\View */

if($formAction == null){
$this->title = Yii::t('andahrm/person', 'Create Position New');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Person'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullname, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Position'), 'url' => ['view-position', 'id' => $model->user_id]];
//$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
$this->params['breadcrumbs'][] = $this->title;
}



$modals['position'] = Modal::begin([
    'header' => Yii::t('andahrm/structure', 'Create Position'),
    'size' => Modal::SIZE_LARGE
]);
// echo $this->render('@andahrm/edoc/views/default/_form', ['model' => new \andahrm\edoc\models\Edoc(), ]);
echo Yii::$app->runAction('/structure/position/create-ajax', ['formAction' => Url::to(['/structure/position/create-ajax'])]);
// echo '<iframe src="" frameborder="0" style="width:100%; height: 100%;" id="iframe_edoc_create"></iframe>';
            
Modal::end();

$modals['edoc'] = Modal::begin([
    'header' => Yii::t('andahrm/edoc', 'Create Edoc'),
    'size' => Modal::SIZE_LARGE
]);
// echo $this->render('@andahrm/edoc/views/default/_form', ['model' => new \andahrm\edoc\models\Edoc(), ]);
echo Yii::$app->runAction('/edoc/default/create-ajax1', ['formAction' => Url::to(['/edoc/default/create-ajax1'])]);
// echo '<iframe src="" frameborder="0" style="width:100%; height: 100%;" id="iframe_edoc_create"></iframe>';
Modal::end();
?>
<?php 
  $formOptions['options'] = ['data-pjax' => ''];
  $formOptions['options'] = ['enctype' => 'multipart/form-data'];
  if($formAction !== null)  $formOptions['action'] = $formAction;
  
  $form = ActiveForm::begin($formOptions); 
  ?>
<div class="positions-form">

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'positions_dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.positions-container-items', // required: css class selector
        'widgetItem' => '.positions-item', // required: css class
        'limit' => 4, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.positions-add-item', // css class
        'deleteButton' => '.positions-remove-item', // css class
        'model' => $models[0],
        'formId' => $form->id,
        'formFields' => [
            //'user_id',
            'adjust_date',
            'title',
            'position_id',
            'position_type_id',
            'position_level_id',
            'level',
            'salary',
            'status',
            'edoc_id',
            'edoc[code]',
            'edoc[title]',
            'edoc[date_code]',
            'edoc[file]',
        ],
    ]); ?>
    
    <h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
        <span class="label label-success">
            <?=Yii::t('andahrm/person', 'Position History')?>
        </span>
        <button type="button" class="pull-right positions-add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> 
        <?=Yii::t('andahrm', 'Add List')?></button>
    </h2> 
    
        <div class="positions-container-items">
            <?php foreach ($models as $index => $model): ?>
            <div class="positions-item panel panel-default">
                <div class="panel-body" style="padding:8px;">
                    
                    <button type="button" class="pull-right positions-remove-item btn btn-danger btn-xs">
                        <i class="fa fa-minus"></i>
                    </button>
                    <h4 class="page-header green panel-title-positions" style="margin-top: 0">
                        <?=Yii::t('andahrm', 'List')?>: <?= ($index + 1) ?>
                    </h4>
                    <div class="clearfix"></div>
                    
                   <div class="row">
                       <?php #echo $form->errorSummary($model); ?>
                        <?php 
                         if (! $model->isNewRecord) {
                            $form->field($model,"[{$index}]user_id")->hiddenInput()->label(false)->hint(false)->error(false);
                        }
                        ?>
                        
                        <?=$form->field($model,"[{$index}]adjust_date",['options' => ['class' => 'form-group col-xs-3 col-sm-3 adjust_date']])
                         ->widget(DatePicker::classname(), WidgetSettings::DatePicker());?>
                
                        <?php /*=$form->field($model,"[{$index}]title",[
                            'options' => ['class' => 'form-group  col-xs-3 col-sm-3'],
                        ])->widget(Typeahead::classname(),[
    'options' => ['placeholder' => 'Filter as you type ...','id'=>"personpositionsalary-{$index}-title"],
    'pluginOptions' => ['highlight'=>true],
    'dataset' => [
        [
            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
            'display' => 'value',
            'prefetch' => Url::to(['/structure/position/get-title']),
            'remote' => [
                'url' => Url::to(['/structure/position/get-title']) . '?q=%QUERY' ,
                'wildcard' => '%QUERY'
            ]
        ]
    ]
]);*/
?>


         
                        
<?php                   
$toPositionCreate = Url::to(['/structure/position/create']);
if($formAction){
$positionInputTemplate = <<< HTML
<div class="input-group">
    {input}
    <span class="input-group-addon btn btn-success btn-create-position" data-key="{$index}" >
    <a href="{$toPositionCreate}" target="_bank">
        <i class="fa fa-plus"></i>
    </a>
    </span>
</div>
HTML;
}else{
$positionInputTemplate = <<< HTML
<div class="input-group">
    {input}
    <span class="input-group-addon btn btn-success btn-create-position" data-key="{$index}" role="position" data-toggle="modal" data-target="#{$modals['position']->id}" >
        <i class="fa fa-plus"></i>
    </span>
</div>
HTML;
}
?>                        

                         <?=$form->field($model, "[{$index}]position_id",[
                             'inputTemplate' => $positionInputTemplate,
                             'options' => ['class' => 'form-group col-xs-6 col-sm-6']
                             ])
                            ->widget(Select2::classname(),
                                [
                                    'data' => Position::getListTitle(),
                                    'options' => ['placeholder' => Yii::t('andahrm/person', 'Search for a position')],
                                    'pluginOptions' => [
                                        //'tags' => true,
                                        //'tokenSeparators' => [',', ' '],
                                        'allowClear'=>true,
                                        'minimumInputLength'=>2,//ต้องพิมพ์อย่างน้อย 3 อักษร ajax จึงจะทำงาน
                                        'ajax'=>[
                                            'url'=>Url::to(['/structure/position/position-list']),
                                            'dataType'=>'json',//รูปแบบการอ่านคือ json
                                            'data'=>new JsExpression('function(params) { return {q:params.term};}')
                                         ],
                                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                        'templateResult' => new JsExpression('function (position) { return position.text; }'),
                                        'templateSelection' => new JsExpression('function (position) { return position.text; }'),
                                    ],
                                ]
                            )->hint(false); ?>
                        
                        <?= $form->field($model,"[{$index}]status",['options'=>['class'=>'form-group col-sm-3']])->dropDownList(PersonPositionSalary::getItemStatus());?>

                            
                        <?php 
                        //echo $form->field($model,"[{$index}]level",['options' => ['class' => 'form-group  col-xs-3 col-sm-3']])
                        //->textInput();
                        ?>


          <?php /*= $form->field($model, "[{$index}]position_type_id",[
              'options' => ['class' => 'form-group  col-xs-3 col-sm-3']
              ])->dropDownList(PositionType::getList(),['prompt'=>Yii::t('app','Select')]);
          //->dropDownList(PositionType::getList(),['prompt'=>Yii::t('app','Select')])
          */?>
          
</div>
<div class="row">
    <?php echo $form->field($model,"[{$index}]level",['options'=>['class'=>'form-group col-sm-3']])->textInput();?>
          <?php /*= $form->field($model, "[{$index}]position_level_id",[
              'options' => ['class' => 'form-group  col-xs-3 col-sm-3']
              ])->dropDownList(
              PositionLevel::getList(),['prompt'=>Yii::t('app','Select')]);
              */
          
          /*->widget(DepDrop::classname(), [
            'options'=>['id'=>"ddl-position_level-{$index}"],
            'data'=> PositionLevel::getPositionLevels($model->person_type_id,$model->position_type_id),
            'type'=>DepDrop::TYPE_SELECT2,
            'pluginOptions'=>[
                'depends'=>["ddl-position_type-{$index}"],
                'placeholder'=>Yii::t('app','Select'),
                'url'=>Url::to(['/structure/position/get-position-level'])
            ],
            'pluginEvents' => [
              //'change' => "function(event, id, value, count) { alert(value); }",
              ]
        ]); */ ?>
        
        
<!--      </div>-->

<!--<div class="row">-->
    
                        
                        <?=$form->field($model,"[{$index}]salary",['options' => ['class' => 'form-group  col-xs-4 col-sm-3']])
                        ->textInput(['type'=>'number']);?>
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
                             'options' => ['class' => 'form-group  col-xs-6 col-sm-6'
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
                                            'url'=>Url::to(['/edoc/default/get-list']),
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
                    
                        <div class="row">
                            <?php #= $form->errorSummary($modelsEdoc); ?>
                            
                            
                            <div class="new_edoc_area" data-key="<?=$index?>" style="display:none;">
                                
                                <?=$form->field($modelsEdoc[0],"[{$index}]code",[
                                'options' => ['class' => 'form-group col-sm-2']
                                ])->textInput(['disabled'=>'disabled']);?>
                                
                                <?=$form->field($modelsEdoc[0], "[{$index}]date_code",
                                ['options' => ['class' => 'form-group col-sm-2 date_code']])
                                ->widget(DatePicker::classname(), WidgetSettings::DatePicker(['options' => ['disabled'=>'disabled']]));
                                ?>
                                
                                <?=$form->field($modelsEdoc[0],"[{$index}]title",[
                                'options' => ['class' => 'form-group col-sm-4']
                                ])->textInput(['disabled'=>'disabled']);?>
                                
                                
                                
                                 <?= $form->field($modelsEdoc[0], "[{$index}]file",['options' => ['class' => 'form-group col-sm-4']])
                                 ->widget(FileInput::classname(), [
                                    'options' => ['disabled'=>'disabled'],
                                    'pluginOptions' => [
                                      'previewFileType' => 'pdf',
                                      'elCaptionText' => '#customCaption',
                                      'uploadUrl' => Url::to(['/edoc/default/file-upload']),
                                      'showPreview' => false,
                                      'showCaption' => true,
                                      'showRemove' => true,
                                      'showUpload' => false,
                                    ],
                                    
                                ]);?>
                                
                                <?php #echo $edocInputId = Html::getInputId($modelsEdoc, "[{$index}]file");?>
                        </div>
                        
                        
                        
                        
                    </div><!-- end:row -->

                    
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php DynamicFormWidget::end(); ?>
    
     <div class="form-group">
         <?= Html::submitButton( Yii::t('andahrm', 'Save') , ['class' =>  'btn btn-success' ]) ?>
    </div>
</div>

    <?php ActiveForm::end(); ?>
<?php
###############################################################################################################################
###############################################################################################################################
###############################################################################################################################

$this->registerJs("
function initSelect2Loading(a,b){ initS2Loading(a,b); }
function initSelect2DropStyle(id, kvClose, ev){ initS2Open(id, kvClose, ev); }
", 
$this::POS_HEAD);


$listLabel = Yii::t('andahrm', 'List');
$js[] = <<< JS
bindBtnAddEdoc();
bindBtnAddPosition();
jQuery(".positions_dynamicform_wrapper").on('afterInsert', function(e, item) {
    
    
    $( ".adjust_date" ).each(function() {
           $(this).find('input').datepicker({
               "language":"th-th",
               "autoclose":true,
               //"daysOfWeekDisabled":[0,6],
            });
      });   
      
      $( ".date_code" ).each(function() {
           $(this).find('input').datepicker({
               "language":"th-th",
               "autoclose":true,
               //"daysOfWeekDisabled":[0,6],
            });
      }); 
      
    $(".positions_dynamicform_wrapper .panel-title-positions").each(function(index) {
        jQuery(this).html("{$listLabel}: " + (index + 1));
    });
    
    
    bindBtnAddEdoc();
    bindBtnAddPosition();
    
});

jQuery(".positions_dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".positions_dynamicform_wrapper .panel-title-positions").each(function(index) {
        jQuery(this).html("{$listLabel}: " + (index + 1));
    });
    bindBtnAddEdoc();
    bindBtnAddPosition();
});

var input_edoc = '';
function bindBtnAddEdoc(){
    //$(".positions_dynamicform_wrapper .new_edoc").each(function(index) {
        $(".positions_dynamicform_wrapper .btn-create-edoc").each(function(index) {
            $(this).unbind("click");
            $(this).bind("click",function(){
                $(this).attr('data-key',index);
                input_edoc = $(this).attr('data-key');
                //alert(input_edoc);
            });
        });
        // $(this).attr('data-key',index);
        // //var key = index;
        // var area = $(".positions_dynamicform_wrapper .new_edoc_area:eq("+index+")").attr('data-key',index);
        
        
        // $(this).unbind('click');
        // $(this).bind('click',function(){
        //     if(!$(this).is('.shown')){
        //         $(this).find("i").removeClass('fa-plus');
        //         $(this).find("i").addClass('fa-minus');
        //         $(this).addClass('shown');
        //         $(area).find('input').attr('disabled',false);
        //         $(area).find("#edoc-"+index+"-file").attr('disabled',false);
        //         $(area).find("#edoc-"+index+"-file").fileinput('refresh');
        //         $(area).show();
        //     }else{
        //          $(this).removeClass('shown');
        //          $(this).find("i").addClass('fa-plus');
        //          $(this).find("i").removeClass('fa-minus');
        //          $(area).find('input').attr('disabled',true);
        //         $(area).find("#edoc-"+index+"-file").attr('disabled',true);
        //         $(area).find("#edoc-"+index+"-file").fileinput('refresh');
        //         $(area).hide();
        //     }
        // });
    //});
}
var input_position = '';
function bindBtnAddPosition(){
    $(".positions_dynamicform_wrapper .btn-create-position").each(function(index) {
        $(this).unbind("click");
        $(this).bind("click",function(){
            $(this).attr('data-key',index);
            input_position = $(this).attr('data-key');
            //alert(input_position);
        });
    });
}
JS;
    
$this->registerJs(implode("\n", $js), $this::POS_END);


$positionInputId = Html::getInputId($model, 'position_id');
$jsHead[] = <<< JS
function callbackPosition(result,form)
{   
    $("#personpositionsalary-"+input_position+"-position_id").append($('<option>', {
        value: result.id,
        text: result.code + ' - ' + result.title
    }));
    $("#personpositionsalary-"+input_position+"-position_id").val(result.id).trigger('change.select2');
    
    $("#{$modals['position']->id}").modal('hide');
    //alert(form);
    $(form).trigger("reset");
}
JS;
$edocInputId = Html::getInputId($model, 'edoc_id');
$jsHead[] = <<< JS
function callbackEdoc(result,form)
{   
    $("#personpositionsalary-"+input_edoc+"-edoc_id").append($('<option>', {
        value: result.id,
        text: result.code + ' ' + result.date_code + ' ' + result.title
    }));
    $("#personpositionsalary-"+input_edoc+"-edoc_id").val(result.id).trigger('change.select2');
    
    $("#{$modals['edoc']->id}").modal('hide');
    $(form).trigger("reset");
}
JS;

$this->registerJs(implode("\n", $jsHead), $this::POS_HEAD);
?>