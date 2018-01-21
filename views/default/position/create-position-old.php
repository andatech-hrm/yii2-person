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
use andahrm\structure\models\PositionOld;
use yii\helpers\Json;


$this->title = Yii::t('andahrm/person', 'Create Position Old');
$this->params['breadcrumbs'][] = $this->title;
/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonPostionSalary */
/* @var $form yii\widgets\ActiveForm */
$modals['position'] = Modal::begin([
    'header' => Yii::t('andahrm/person', 'Edoc'),
    'size' => Modal::SIZE_LARGE
]);
//echo Yii::$app->runAction('/structure/position-old/create', ['formAction' => Url::to(['/structure/position-old/create'])]);
            
Modal::end();


$modals['edoc'] = Modal::begin([
    'header' => Yii::t('andahrm/person', 'Edoc'),
    'size' => Modal::SIZE_LARGE
]);
echo Yii::$app->runAction('/edoc/default/create-ajax', ['formAction' => Url::to(['/edoc/default/create-ajax'])]);
            
Modal::end();
?>


  
  <?php 
  $formOptions['options'] = ['data-pjax' => ''];
  $formOptions['layout'] = 'horizontal';
  $formOptions['fieldConfig'] = [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{endWrapper}{error}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-3',
                    'offset' => 'col-sm-offset-2',
                    'wrapper' => 'col-sm-4',
                    'error' => 'col-sm-3',
                    'hint' => '',
                ],
            ];
  if($formAction !== null)  $formOptions['action'] = $formAction;
  
  $form = ActiveForm::begin($formOptions); 
  ?>
<div class="x_panel tile">
    <div class="x_title">
        <h2><?= $this->title; ?></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

         <?php echo $form->field($model,'user_id')->hiddenInput()->label(false)->hint(false)->error(false);?>
         
          <?php echo $form->field($model,'adjust_date')->widget(DatePicker::classname(), [              
          'options' => [
            'daysOfWeekDisabled' => [0, 6],
          ]
        ]);
          ?>

         <?php echo $form->field($model,'title',[
            'horizontalCssClasses' => [
                    'wrapper' => 'col-sm-6',
                ]
        ])->textInput();?>
 

       
        ?>
<?php
// $positionInputTemplate = <<< HTML
// <div class="input-group">
//     {input}
//     <span class="input-group-addon btn btn-success"  role="position" data-toggle="modal" data-target="#{$modals['position']->id}">
//         <i class="fa fa-plus"></i>
//     </span>
// </div>
// HTML;        
        echo $form->field($model, 'position_old_id',[
        // 'inputTemplate' => $positionInputTemplate,
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
        
         <?php echo $form->field($model,'level')->textInput();?>
         <?php echo $form->field($model,'salary')->textInput();?>
       
        
<?php 

$edocInputTemplate = <<< HTML
<div class="input-group">
    {input}
    <span class="input-group-addon btn btn-success"  role="edoc" data-toggle="modal" data-target="#{$modals['edoc']->id}">
        <i class="fa fa-plus"></i>
    </span>
</div>
HTML;
echo $form->field($model, "edoc_id", [
        'inputTemplate' => $edocInputTemplate,
        // 'options' => [
        //     'class' => 'form-group col-sm-6'
        // ]
    ])->widget(Select2::className(), WidgetSettings::Select2(['data' => Edoc::getList()]));
    
?>
            

  
 
                    


        <div class="form-group">
             <div class="col-sm-9 col-sm-offset-3">
                <?= Html::submitButton(Yii::t('andahrm', 'Save') , ['class' => 'btn btn-success']) ?>
                <?= Html::a(Yii::t('andahrm/position-salary', 'Cencel') , ['view-position','id'=>$model->user_id],['class' => 'btn btn-link']) ?>
            </div>
        </div>


        <div class="clearfix"></div>
    </div>
</div>
    <?php ActiveForm::end(); ?>



<?php
$edocInputId = Html::getInputId($model, 'edoc_id');
$jsHead[] = <<< JS
function callbackEdoc(result)
{   
    $("#{$edocInputId}").append($('<option>', {
        value: result.id,
        text: result.code + ' - ' + result.title
    }));
    $("#{$edocInputId}").val(result.id).trigger('change.select2');
    
    $("#{$modals['edoc']->id}").modal('hide');
}
JS;


$this->registerJs(implode("\n", $jsHead), $this::POS_HEAD);
?>
