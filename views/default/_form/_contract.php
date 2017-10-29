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
use kartik\widgets\DepDrop;
use yii\web\JsExpression;
use yii\bootstrap\Modal;


use andahrm\edoc\models\Edoc;
use andahrm\structure\models\PersonType;
use andahrm\structure\models\PositionLine;
use andahrm\structure\models\Section;
use andahrm\structure\models\Position;
use andahrm\structure\models\PositionOld;
/* @var $this yii\web\View */


// $modals['position'] = Modal::begin([
//             'header' => Yii::t('andahrm/person', 'Position'),
//             'size' => Modal::SIZE_LARGE
//             ]);
//     echo Yii::$app->runAction('/person/default/create-position', [
//         'formAction' => Url::to(['/person/default/create-position','id'=>$this->context->user_id,'from'=>'tab']),
//         'id'=>$this->context->user_id,
//         //'modal_edoc_id'=>$modals['edoc']->id,
//         ]);
// Modal::end();
?>
<?php 
$formOptions = [];
  $formOptions['id'] = 'form_contract';
  //$formOptions['options'] = ['data-pjax' => ''];
 // $formOptions['options'] = ['enctype' => 'multipart/form-data'];
  if($formAction !== null)  $formOptions['action'] = $formAction;
  
  $form = ActiveForm::begin($formOptions); 
  ?>
<div class="contract-form">
    
    
    <div class="row">
        <?= $form->field($model, 'position_old',['options' => ['class' => 'form-group col-sm-2']])
        ->dropDownList([
            0=>Yii::t('andahrm/person',"Position New"),
            1=>Yii::t('andahrm/person',"Position Old"),
        ],[
              'prompt'=>Yii::t('app','Select'),
            ])?>
    </div>
    
    <div class="row search_position" style="display:none;">
        <?= $form->field($model, 'section_id',['options' => ['class' => 'form-group col-sm-4']])->dropDownList(Section::getList(),['prompt'=>Yii::t('app','Select')]) ?>
          
        <?= $form->field($model, 'person_type_id',['options' => ['class' => 'form-group col-sm-4']])
            ->dropDownList(PersonType::getList(),[
              'prompt'=>Yii::t('app','Select'),
            ]) ?>
          
        <?= $form->field($model, 'position_line_id',['options' => ['class' => 'form-group col-sm-4']])
        ->widget(DepDrop::classname(), [
                'options'=>[
                    'prompt'=>Yii::t('app','Select'),
                ],
                'data'=> PositionLine::getListByPersonType($model->person_type_id,$model->section_id),
                'pluginOptions'=>[
                    'depends'=>['personcontract-section_id', 'personcontract-person_type_id'],
                    'placeholder'=>Yii::t('app','Select'),
                    'url'=>Url::to(['/position-salary/default/get-position-line'])
                ]
            ]); ?>
    </div>
    
    <div class="row">

                      
<?php                   
$toPositionCreate = Url::to(['/structure/position/create']);
if($formAction){
$positionInputTemplate = <<< HTML
<div class="input-group">
    {input}
    <span class="input-group-addon btn btn-success btn-create-position"  >
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
    <span class="input-group-addon btn btn-success btn-create-position" role="position" data-toggle="modal"  >
        <i class="fa fa-plus"></i>
    </span>
</div>
HTML;
}
?>   
        
        <?= $form->field($model, 'position_id',[
            'inputTemplate' => $positionInputTemplate,
             'options' => ['class' => 'form-group col-xs-6 col-sm-6']
             ])->widget(Select2::classname(),[
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
                            ); ?>
            
            <?php                        
$edocInputTemplate = <<< HTML
<div class="input-group">
    {input}
    <span class="input-group-addon btn btn-success new_edoc" >
        <i class="fa fa-plus"></i>
    </span>
</div>
HTML;
?>
                         <?=$form->field($model, "edoc_id",[
                             'inputTemplate' => $edocInputTemplate,
                             'options' => ['class' => 'form-group col-sm-6'
                             ]])
                         ->widget(Select2::className(), WidgetSettings::Select2(['data' => Edoc::getList()]));
                        ?>
    </div>
    
    
    <div class="row new_edoc_area"  style="display:none;">
                                
                <?=$form->field($modelEdoc,"code",[
                'options' => ['class' => 'form-group col-sm-2']
                ])->textInput(['disabled'=>'disabled']);?>
                
                <?=$form->field($modelEdoc,"title",[
                'options' => ['class' => 'form-group col-sm-4']
                ])->textInput(['disabled'=>'disabled']);?>
                
                <?=$form->field($modelEdoc, "date_code",
                ['options' => ['class' => 'form-group col-sm-2 date_code']])
                ->widget(DatePicker::classname(), WidgetSettings::DatePicker(['options' => ['disabled'=>'disabled']]));
                ?>
                
                 <?= $form->field($modelEdoc, "file",['options' => ['class' => 'form-group col-sm-4']])
                 ->widget(FileInput::classname(), [
                    'options' => ['accept' => 'pdf/*,image/*','disabled'=>'disabled'],
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
        
        
    </div><!-- end:row -->

 
    
    <div class="row">
        <?= $form->field($model, 'start_date',['options' => ['class' => 'form-group col-sm-4']])
        ->widget(DatePicker::classname(),  WidgetSettings::DatePicker());?>
    
        <?= $form->field($model, 'end_date',['options' => ['class' => 'form-group col-sm-4']])
        ->widget(DatePicker::classname(),  WidgetSettings::DatePicker());?>
        
        <?= $form->field($model, 'work_date',['options' => ['class' => 'form-group col-sm-4']])
        ->widget(DatePicker::classname(), WidgetSettings::DatePicker());?>
    </div>
    
     <div class="form-group">
         <?= Html::submitButton( Yii::t('andahrm', 'Save') , ['class' =>  'btn btn-success' ]) ?>
    </div>
</div>

    <?php ActiveForm::end(); ?>
    <?php
///Surakit
$position_old = Html::getInputId($model, "position_old");
$edoc_id = Html::getInputId($model, "edoc_id");
$formId = $form->id;
$js[] = <<< JS
    $("#{$position_old}").on("change",function(){
        if($(this).val()==1){
            $(".contract-form .search_position").hide();
        }else{
            $(".contract-form .search_position").show();
        }
    });
    
    
     var area = $(".contract-form .new_edoc_area");
    $(".contract-form .new_edoc").unbind('click');
    $(".contract-form .new_edoc").bind('click',function(){
        if(!$(this).is('.shown')){
            $(this).find("i").removeClass('fa-plus');
            $(this).find("i").addClass('fa-minus');
            $(this).addClass('shown');
            $(area).find('input').attr('disabled',false);
            $(area).find("#edoc-file").attr('disabled',false);
            $(area).find("#edoc-file").fileinput('refresh');
            $(area).show();
        }else{
             $(this).removeClass('shown');
             $(this).find("i").addClass('fa-plus');
             $(this).find("i").removeClass('fa-minus');
             $(area).find('input').attr('disabled',true);
            $(area).find("#edoc-file").attr('disabled',true);
            $(area).find("#edoc-file").fileinput('refresh');
            $(area).hide();
        }
    });
    // alert(5515); 
    // $('button[type=submit]').on('click',function(){
    //   alert(555); 
    // });
JS;

if($formAction) {

$js[] = <<< JS
//5678
    jQuery(document).on('submit', "#{$formId}", function(e){
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(form[0]);
        alert(form.serialize());
        
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
                    callbackContract(data.result);
                }else{
                    alert('Fail');
                }
            }
        });
    });
JS;

}

 $this->registerJs(implode("\n", $js));
?>