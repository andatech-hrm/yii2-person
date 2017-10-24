<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use andahrm\datepicker\DatePicker;
use kartik\widgets\FileInput;
use kartik\widgets\Typeahead;

use kartik\widgets\Select2;
use andahrm\setting\models\WidgetSettings;
use andahrm\edoc\models\Edoc;
use andahrm\structure\models\Position;
use andahrm\structure\models\PositionOld;
use andahrm\positionSalary\models\PersonPositionSalary;
use yii\helpers\Json;

$modals['position'] = Modal::begin([
    'header' => Yii::t('andahrm/structure', 'Create Position Old'),
    'size' => Modal::SIZE_LARGE
]);
// echo $this->render('@andahrm/edoc/views/default/_form', ['model' => new \andahrm\edoc\models\Edoc(), ]);
echo Yii::$app->runAction('/structure/position-old/create-ajax', ['formAction' => Url::to(['/structure/position-old/create-ajax'])]);
// echo '<iframe src="" frameborder="0" style="width:100%; height: 100%;" id="iframe_edoc_create"></iframe>';
            
Modal::end();
/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonPostionSalary */
/* @var $form yii\widgets\ActiveForm */
 //$formOptions['options'] = ['data-pjax' => ''];
  //$formOptions['options'] = ['enctype' => 'multipart/form-data'];
  $formOptions = [];
  if(isset($formAction) && $formAction !== null)  $formOptions['action'] = Url::to([$formAction],false);
$form = ActiveForm::begin($formOptions);
?>
    <?php echo $form->field($model,'user_id')->hiddenInput()->label(false)->hint(false)->error(false);?>
         

    <div class="row">
       
          <?=$form->field($model,'adjust_date',['options'=>['class'=>'form-group col-sm-4']])
          ->widget(DatePicker::classname(), WidgetSettings::DatePicker());?>

        <?php /*echo $form->field($model,'title',['options'=>['class'=>'form-group col-sm-4']])->textInput();*/?>
    
       
<?php                   
$toPositionCreate = Url::to(['/structure/position-old/create']);
$positionInputTemplate = <<< HTML
<div class="input-group">
    {input}
    <span class="input-group-addon btn btn-success btn-create-position" role="position" data-toggle="modal" data-target="#{$modals['position']->id}" >
        <i class="fa fa-plus"></i>
    </span>
</div>
HTML;
?>  
        <?=$form->field($model, 'position_old_id',[
            'inputTemplate' => $positionInputTemplate,
             'options' => ['class' => 'form-group col-sm-6']
            ])->widget(Select2::classname(),
                                [
                                    'data' => PositionOld::getListTitle(),
                                    //'value'=>$model->position_old_id,
                                    'options' => ['placeholder' => Yii::t('andahrm/person', 'Search for a position')],
                                    'pluginOptions' => [
                                        //'tags' => true,
                                        //'tokenSeparators' => [',', ' '],
                                        'allowClear'=>true,
                                        'minimumInputLength'=>2,//ต้องพิมพ์อย่างน้อย 3 อักษร ajax จึงจะทำงาน
                                        'ajax'=>[
                                            'url'=>Url::to(['/structure/position-old/position-list']),
                                            'dataType'=>'json',//รูปแบบการอ่านคือ json
                                            'data'=>new JsExpression('function(params) { return {q:params.term};}')
                                         ],
                                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                        'templateResult' => new JsExpression('function (position) { return position.text; }'),
                                        'templateSelection' => new JsExpression('function (position) { return position.text; }'),
                                    ],
                                ]
                            )->hint(false);
            //     ->hint(false)
            //      ->widget(Typeahead::classname(),
            //         [
            //             'options' => ['placeholder' => 'Filter as you type ...'],
            //             'pluginOptions' => ['highlight'=>true],
            //             'dataset' => [
            //                 [
            //                     'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
            //                     'display' => 'value',
            //                     //'prefetch' => $baseUrl . '/samples/countries.json',
            //                     'prefetch' => Url::to(['/structure/position-old/position-list']),
            //                     'remote' => [
            //                         'url' => Url::to(['/structure/position-old/position-list']) . '?q=%QUERY',
            //                         'wildcard' => '%QUERY'
            //                     ]
            //                 ]
            //             ]
            //         ]
            //  ); 
         ?>
         
          <?= $form->field($model,'status',['options'=>['class'=>'form-group col-sm-2']])->dropDownList(PersonPositionSalary::getItemStatus());?>
        
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

$formId = $form->id;
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
if($formAction !== null) {
    /*
$jsHead[] = <<< JS
var index=0;
$(document).on('submit', "#{$formId}", function(e){
  e.preventDefault();
  var form = $("#{$formId}");
  var formData = new FormData(form[0]);
  // alert(form.serialize());
  alert(form.attr('action'));
  
  ++index;
  console.log('index='+index);
  if(index==1){
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
  }
});
JS;
*/
}

$this->registerJs(implode("\n", $jsHead));
?>
