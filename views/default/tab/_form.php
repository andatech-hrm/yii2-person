 <?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use kuakling\smartwizard\Step;
?>
 
 
 <?php $form = ActiveForm::begin([
    //'enableAjaxValidation' => true,
    'options' => [
        'role'=>"form",
        'data-toggle'=>"validator",
        'accept-charset'=>"utf-8",
        'novalidate'=>"true",
        'enctype' => 'multipart/form-data',
    ]
]); 

if($models['Person']->user_id)
echo $form->field($models['Person'], 'user_id')->hiddenInput()->label(false)->error(false);
echo Html::hiddenInput('step',$step);

$configBtnWizard = ['step'=>$step,'formSteps'=>$this->context->formSteps,'id'=>$models['Person']->user_id];

?>
 
 
    
    <?= $this->render('btnWizard', $configBtnWizard); ?>
     
    
    <div class="sw-container tab-content">
        <div class="step-content" style="display:block;">
            <?= $this->render('_step-'.$step, ['models' => $models,'form'=>$form]); ?>
        </div>
    </div>
    
    <?= $this->render('btnWizard', $configBtnWizard); ?>
   
    

<?php ActiveForm::end(); ?>