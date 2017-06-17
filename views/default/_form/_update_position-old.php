<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kuakling\datepicker\DatePicker;
use kartik\widgets\FileInput;
use kartik\widgets\Typeahead;

use kartik\widgets\Select2;
use andahrm\setting\models\WidgetSettings;
use andahrm\edoc\models\Edoc;
use andahrm\structure\models\Position;
use andahrm\structure\models\PositionOld;
use andahrm\positionSalary\models\PersonPositionSalary;
use yii\helpers\Json;


/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonPostionSalary */
/* @var $form yii\widgets\ActiveForm */
$form = ActiveForm::begin();
?>
    <?php echo $form->field($model,'user_id')->hiddenInput()->label(false)->hint(false)->error(false);?>
         

    <div class="row">
        <?php if($old):?>
          <?=$form->field($model,'adjust_date',['options'=>['class'=>'form-group col-sm-4']])
          ->widget(DatePicker::classname(), [              
          'options' => [
            'daysOfWeekDisabled' => [0, 6],
          ]
        ]);?>

        <?= $form->field($model,'title',['options'=>['class'=>'form-group col-sm-4']])->textInput();?>
    
        
        <?=$form->field($model, 'position_old_id',['options'=>['class'=>'form-group col-sm-4']])
                ->widget(Select2::classname(),
                    WidgetSettings::Select2([
                        'data' => PositionOld::getList(),
                        'pluginOptions' => [
                            'tags' => true,
                            'tokenSeparators' => [',', ' '],
                            'maximumInputLength' => 10
                        ],
                    ])
         ); ?>
         <?php else:?>
         
          <?=$form->field($model,'adjust_date',['options'=>['class'=>'form-group col-sm-3']])
          ->widget(DatePicker::classname(), [              
          'options' => [
            'daysOfWeekDisabled' => [0, 6],
          ]
        ]);?>

        <?= $form->field($model,'title',['options'=>['class'=>'form-group col-sm-4']])->textInput();?>
    
         
         
         <?=$form->field($model, 'position_id',['options'=>['class'=>'form-group col-sm-3']])
                ->widget(Select2::classname(),
                    WidgetSettings::Select2([
                        'data' => Position::getList(),
                        'pluginOptions' => [
                            //'tags' => true,
                            //'tokenSeparators' => [',', ' '],
                            'maximumInputLength' => 10
                        ],
                    ])
         ); ?>
         
         <?= $form->field($model,'status',['options'=>['class'=>'form-group col-sm-2']])->dropDownList(PersonPositionSalary::getItemStatus());?>
         
         <?php endif;?>
 </div>
 
     <div class="row">
         <?php echo $form->field($model,'level',['options'=>['class'=>'form-group col-sm-2']])->textInput();?>
         <?php echo $form->field($model,'salary',['options'=>['class'=>'form-group col-sm-4']])->textInput();?>
         
<?php 

$formId = $form->id;
$edocInputTemplate = <<< HTML
<div class="input-group">
    {input}
    <span class="input-group-addon btn btn-primary edit_edoc_old-{$formId}" >
        <i class="fa fa-pencil"></i>
    </span>
    <span class="input-group-addon btn btn-success new_edoc_old-{$formId}" >
        <i class="fa fa-plus"></i>
    </span>
</div>
HTML;
echo $form->field($model, "edoc_id", [
        'options'=>['class'=>'form-group col-sm-6'],
        'inputTemplate' => $edocInputTemplate,
        // 'options' => [
        //     'class' => 'form-group col-sm-6'
        // ]
    ])->widget(Select2::className(), WidgetSettings::Select2(['data' => Edoc::getList()]));
    
?>
    </div>


<div class="edoc_area edic_edoc_old_area-<?=$formId?>" style="display:none;">
    <?=Html::tag('h2',Yii::t('andahrm','Update').Yii::t('andahrm','Edoc'))?>
    <div class="row">
                                
        <?=$form->field($modelEdoc,"id")->hiddenInput()->label(false)->hint(false)->error(false)?>
        
        <?=$form->field($modelEdoc,"code",[
        'options' => ['class' => 'form-group col-sm-2']
        ])->textInput(['disabled'=>'disabled']);?>
        
        <?=$form->field($modelEdoc, "date_code",
        ['options' => ['class' => 'form-group col-sm-2 date_code']])
        ->widget(DatePicker::classname(), WidgetSettings::DatePicker(['options' => ['disabled'=>'disabled']]));
        ?>
        
        <?=$form->field($modelEdoc,"title",[
        'options' => ['class' => 'form-group col-sm-4']
        ])->textInput(['disabled'=>'disabled']);?>
        
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
</div>    
</div>

<div class="edoc_area new_edoc_old_area-<?=$formId?>" style="display:none;">
    <?=Html::tag('h2',Yii::t('andahrm','Create').Yii::t('andahrm','Edoc'))?>
    <div class="row">
                                
        <?=$form->field($newModelEdoc,"code",[
        'options' => ['class' => 'form-group col-sm-2']
        ])->textInput(['disabled'=>'disabled']);?>
        
        <?=$form->field($newModelEdoc, "date_code",
        ['options' => ['class' => 'form-group col-sm-2 date_code']])
        ->widget(DatePicker::classname(), WidgetSettings::DatePicker(['options' => ['disabled'=>'disabled']]));
        ?>
        
        <?=$form->field($newModelEdoc,"title",[
        'options' => ['class' => 'form-group col-sm-4']
        ])->textInput(['disabled'=>'disabled']);?>
        
        <?= $form->field($newModelEdoc, "file",['options' => ['class' => 'form-group col-sm-4']])
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
</div>    
</div>


    <div class="form-group">
        <?= Html::submitButton( Yii::t('andahrm', 'Save') , ['class' =>  'btn btn-success' ]) ?>
    </div>
 
<?php
ActiveForm::end();
?>
 


<?php
$jsHead[] = <<< JS

        var form = $("form#{$formId}");
        var areaNew = $(form).find(".new_edoc_old_area-{$formId}");
        var areaEdic = $(form).find(".edic_edoc_old_area-{$formId}");
        var edcoArea = $(form).find(".edoc_area");
        $(form).find(".new_edoc_old-{$formId}").bind('click',function(){
            //alert(555);
            $(edcoArea).hide();
            if(!$(this).is('.shown')){
                $(this).find("i").removeClass('fa-plus');
                $(this).find("i").addClass('fa-minus');
                $(this).addClass('shown');
                $(areaNew).find('input').attr('disabled',false);
                $(areaNew).find("#edoc-file").attr('disabled',false);
                $(areaNew).find("#edoc-file").fileinput('refresh');
                $(areaNew).show();
            }else{
                 $(this).removeClass('shown');
                 $(this).find("i").addClass('fa-plus');
                 $(this).find("i").removeClass('fa-minus');
                 $(areaNew).find('input').attr('disabled',true);
                $(areaNew).find("#edoc-file").attr('disabled',true);
                $(areaNew).find("#edoc-file").fileinput('refresh');
                $(areaNew).hide();
            }
        });
        
        $(form).find(".edit_edoc_old-{$formId}").bind('click',function(){
            //alert(555);
            $(edcoArea).hide();
            if(!$(this).is('.shown')){
                //$(this).find("i").removeClass('fa-plus');
                //$(this).find("i").addClass('fa-minus');
                $(this).addClass('shown');
                $(areaEdic).find('input').attr('disabled',false);
                $(areaEdic).find("#edoc-file").attr('disabled',false);
                $(areaEdic).find("#edoc-file").fileinput('refresh');
                $(areaEdic).show();
            }else{
                 $(this).removeClass('shown');
                 //$(this).find("i").addClass('fa-plus');
                 //$(this).find("i").removeClass('fa-minus');
                 $(areaEdic).find('input').attr('disabled',true);
                $(areaEdic).find("#edoc-file").attr('disabled',true);
                $(areaEdic).find("#edoc-file").fileinput('refresh');
                $(areaEdic).hide();
            }
        });
JS;

$jsHead[] = <<< JS
$(document).on('submit', '#{$formId}', function(e){
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


$this->registerJs(implode("\n", $jsHead));
?>
