<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kuakling\datepicker\DatePicker;
use kartik\widgets\Select2;
use andahrm\setting\models\WidgetSettings;
use andahrm\edoc\models\Edoc;
use andahrm\structure\models\PositionOld;
use yii\bootstrap\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\DepDrop;


use andahrm\structure\models\PersonType;
use andahrm\structure\models\PositionLine;
use andahrm\structure\models\Section;
/* @var $this yii\web\View */

?>
<?php 
  $formOptions['options'] = ['data-pjax' => ''];
  $formOptions['options'] = ['enctype' => 'multipart/form-data'];
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
        
        
        <?= $form->field($model, 'position_id',['options' => ['class' => 'form-group col-sm-6']]) ->widget(DepDrop::classname(), [
                'options'=>[
                    'prompt'=>Yii::t('app','Select'),
                ],
                //'data'=> PositionLine::getListByPersonType($model->person_type_id,$model->section_id),
                'pluginOptions'=>[
                    'depends'=>['personcontract-section_id', 'personcontract-person_type_id','personcontract-position_line_id','personcontract-position_old'],
                    'placeholder'=>Yii::t('app','Select'),
                    'url'=>Url::to(['/position-salary/default/get-position'])
                ]
            ]); ?>
            
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
        ->widget(DatePicker::classname(), [              
                          'options' => [
                            'daysOfWeekDisabled' => [0, 6],
                          ],
                        ]);?>
    
        <?= $form->field($model, 'end_date',['options' => ['class' => 'form-group col-sm-4']])
        ->widget(DatePicker::classname(), [              
                          'options' => [
                            'daysOfWeekDisabled' => [0, 6],
                          ],
                        ]);?>
        
        <?= $form->field($model, 'work_date',['options' => ['class' => 'form-group col-sm-4']])
        ->widget(DatePicker::classname(), [              
                          'options' => [
                            'daysOfWeekDisabled' => [0, 6],
                          ],
                        ]);?>
    </div>
    
     <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>

    <?php ActiveForm::end(); ?>
    <?php
///Surakit
$position_old = Html::getInputId($model, "position_old");
$edoc_id = Html::getInputId($model, "edoc_id");
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
JS;

if($formAction !== null) {

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
                    callbackContract(data.result);
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