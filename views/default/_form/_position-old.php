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
/* @var $this yii\web\View */

?>
<?php 
  $formOptions['options'] = ['data-pjax' => ''];
  $formOptions['options'] = ['enctype' => 'multipart/form-data'];
  if($formAction !== null)  $formOptions['action'] = $formAction;
  
  $form = ActiveForm::begin($formOptions); 
  ?>
<div class="positions_old-form">

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'positions_old_dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.positions_old-container-items', // required: css class selector
        'widgetItem' => '.positions_old-item', // required: css class
        'limit' => 4, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.positions_old-add-item', // css class
        'deleteButton' => '.positions_old-remove-item', // css class
        'model' => $models[0],
        'formId' => $form->id,
        'formFields' => [
            //'user_id',
            'adjust_date',
            'title',
            'position_old_id',
            'level',
            'salary',
            'edoc_id',
            'edoc[code]',
            'edoc[title]',
            'edoc[date_code]',
            'edoc[file]',
        ],
    ]); ?>
    
    <h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
        <span class="text-muted"><?=Yii::t('andahrm/person', 'Position Old History')?></span>
        <button type="button" class="pull-right positions_old-add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> <?=Yii::t('andahrm', 'Add List')?></button>
    </h2> 
    
        <div class="positions_old-container-items">
            <?php foreach ($models as $index => $model): ?>
            <div class="positions_old-item panel panel-default">
                <div class="panel-body" style="padding:8px;">
                    
                    <button type="button" class="pull-right positions_old-remove-item btn btn-danger btn-xs">
                        <i class="fa fa-minus"></i>
                    </button>
                    <h4 class="page-header green panel-title-positions_old" style="margin-top: 0">
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
                        
                        <?=$form->field($model,"[{$index}]adjust_date",['options' => ['class' => 'form-group col-sm-2 adjust_date']])
                         ->widget(DatePicker::classname(), [              
                          'options' => [
                            'daysOfWeekDisabled' => [0, 6],
                          ],
                        ]);?>
                
                        <?=$form->field($model,"[{$index}]title",[
                            'options' => ['class' => 'form-group col-sm-2'],
                        ])->textInput();?>
                        
                         <?=$form->field($model, "[{$index}]position_old_id",[
                             'options' => ['class' => 'form-group col-sm-2']
                             ])
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
                            
                        <?=$form->field($model,"[{$index}]level",['options' => ['class' => 'form-group col-sm-1']])
                        ->textInput();?>
                        
                        <?=$form->field($model,"[{$index}]salary",['options' => ['class' => 'form-group col-sm-2']])
                        ->textInput();?>
<?php                        
$edocInputTemplate = <<< HTML
<div class="input-group">
    {input}
    <span class="input-group-addon btn btn-success new_edoc" data-key="{$index}">
        <i class="fa fa-plus"></i>
    </span>
</div>
HTML;
?>
                         <?=$form->field($model, "[{$index}]edoc_id",[
                             'inputTemplate' => $edocInputTemplate,
                             'options' => ['class' => 'form-group col-sm-3'
                             ]])
                         ->widget(Select2::className(), WidgetSettings::Select2(['data' => Edoc::getList()]));
                        ?>
                    </div>
                    
                        <div class="row">
                            <?php #= $form->errorSummary($modelsEdoc); ?>
                            
                            <?=$form->field($model,"[{$index}]new_edoc")->hiddenInput()->label(false);?>
                            
                            <div class="new_edoc_area" data-key="<?=$index?>" style="display:none;">
                                
                                <?=$form->field($modelsEdoc[0],"[{$index}]code",[
                                'options' => ['class' => 'form-group col-sm-2']
                                ])->textInput(['disabled'=>'disabled']);?>
                                
                                <?=$form->field($modelsEdoc[0],"[{$index}]title",[
                                'options' => ['class' => 'form-group col-sm-4']
                                ])->textInput(['disabled'=>'disabled']);?>
                                
                                <?=$form->field($modelsEdoc[0], "[{$index}]date_code",
                                ['options' => ['class' => 'form-group col-sm-2 date_code']])
                                ->widget(DatePicker::classname(), WidgetSettings::DatePicker(['options' => ['disabled'=>'disabled']]));
                                ?>
                                
                                 <?= $form->field($modelsEdoc[0], "[{$index}]file",['options' => ['class' => 'form-group col-sm-4']])
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
$this->registerJs("
function initSelect2Loading(a,b){ initS2Loading(a,b); }
function initSelect2DropStyle(id, kvClose, ev){ initS2Open(id, kvClose, ev); }", 
$this::POS_HEAD);


$listLabel = Yii::t('andahrm', 'List');
$js[] = <<< JS
bindBtnAddEdoc();
jQuery(".positions_old_dynamicform_wrapper").on('afterInsert', function(e, item) {
    
    
    $( ".adjust_date" ).each(function() {
           $(this).find('input').datepicker({
               "language":"th-th",
               "autoclose":true,
               "daysOfWeekDisabled":[0,6],
            });
      });   
      
      $( ".date_code" ).each(function() {
           $(this).find('input').datepicker({
               "language":"th-th",
               "autoclose":true,
               "daysOfWeekDisabled":[0,6],
            });
      }); 
      
    $(".positions_old_dynamicform_wrapper .panel-title-positions_old").each(function(index) {
        jQuery(this).html("{$listLabel}: " + (index + 1));
    });
    
    
    bindBtnAddEdoc();
    
});

jQuery(".positions_old_dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".positions_old_dynamicform_wrapper .panel-title-positions_old").each(function(index) {
        jQuery(this).html("{$listLabel}: " + (index + 1));
    });
});


function bindBtnAddEdoc(){
    $(".positions_old_dynamicform_wrapper .new_edoc").each(function(index) {
        $(this).attr('data-key',index);
        //var key = index;
        var area = $(".positions_old_dynamicform_wrapper .new_edoc_area:eq("+index+")").attr('data-key',index);
        
        
        $(this).unbind('click');
        $(this).bind('click',function(){
            if(!$(this).is('.shown')){
                $(this).find("i").removeClass('fa-plus');
                $(this).find("i").addClass('fa-minus');
                $(this).addClass('shown');
                $(area).find('input').attr('disabled',false);
                $(area).find("#edoc-"+index+"-file").attr('disabled',false);
                $(area).find("#edoc-"+index+"-file").fileinput('refresh');
                $(area).show();
            }else{
                 $(this).removeClass('shown');
                 $(this).find("i").addClass('fa-plus');
                 $(this).find("i").removeClass('fa-minus');
                 $(area).find('input').attr('disabled',true);
                $(area).find("#edoc-"+index+"-file").attr('disabled',true);
                $(area).find("#edoc-"+index+"-file").fileinput('refresh');
                $(area).hide();
            }
        });
    });
}
JS;
    
$this->registerJs(implode("\n", $js), $this::POS_END);



///Surakit
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