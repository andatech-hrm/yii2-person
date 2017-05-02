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
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonPostionSalary */
/* @var $form yii\widgets\ActiveForm */
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
  
  $form = ActiveForm::begin($formOptions); ?>




         <?php echo $form->field($model,'title',[
            'horizontalCssClasses' => [
                    'wrapper' => 'col-sm-6',
                ]
        ])->textInput();?>
 

        <?php echo $form->field($model,'adjust_date')->widget(DatePicker::classname(), [              
          'options' => [
            'daysOfWeekDisabled' => [0, 6],
          ]
        ]);?>
       
       <?php echo $form->field($model,'position_id')->widget(DatePicker::classname(), [              
          'options' => [
            'daysOfWeekDisabled' => [0, 6],
          ]
        ]);?>

 
 


        
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
        <?= Html::submitButton(Yii::t('andahrm/position-salary', 'Assign person') , ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('andahrm/position-salary', 'Cencel') , ['index'],['class' => 'btn btn-link']) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>



