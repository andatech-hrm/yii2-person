 <?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use kuakling\smartwizard\Step;

$modals = [];
switch($step){
    case 5:
        // $modals['edoc'] = Modal::begin([
        //         'header' => Yii::t('andahrm/person', 'Edoc'),
        //         'size' => Modal::SIZE_LARGE
        //     ]);
        //     echo Yii::$app->runAction('/edoc/default/create-ajax', ['formAction' => Url::to(['/edoc/default/create-ajax'])]);
        // Modal::end();
        
        $modals['position-old'] = Modal::begin([
            'header' => Yii::t('andahrm/person', 'Position'),
            'size' => Modal::SIZE_LARGE
            ]);
            echo Yii::$app->runAction('/person/default/create-position-old', [
                'formAction' => Url::to(['/person/default/create-position-old','id'=>$this->context->user_id]),
                'id'=>$this->context->user_id,
                //'modal_edoc_id'=>$modals['edoc']->id,
                ]);
        Modal::end();
        
        $modals['position'] = Modal::begin([
            'header' => Yii::t('andahrm/person', 'Position'),
            'size' => Modal::SIZE_LARGE
            ]);
            echo Yii::$app->runAction('/person/default/create-position', [
                'formAction' => Url::to(['/person/default/create-position','id'=>$this->context->user_id]),
                'id'=>$this->context->user_id,
                //'modal_edoc_id'=>$modals['edoc']->id,
                ]);
        Modal::end();
        
        $modals['contract'] = Modal::begin([
            'header' => Yii::t('andahrm/person', 'Contract'),
            'size' => Modal::SIZE_LARGE
            ]);
            echo Yii::$app->runAction('/person/default/create-contract', [
                'formAction' => Url::to(['/person/default/create-contract','id'=>$this->context->user_id]),
                'id'=>$this->context->user_id,
                //'modal_edoc_id'=>$modals['edoc']->id,
                ]);
        Modal::end();
        
        
        break;
}

?>
 
 
 
 
 
 <?php $form = ActiveForm::begin([
    //'enableAjaxValidation' => true,
    'options' => [
        //'role'=>"form",
        //'data-toggle'=>"validator",
        'accept-charset'=>"utf-8",
        //'novalidate'=>"true",
        'enctype' => 'multipart/form-data',
    ]
]); 

// if(isset($models['Person']) && $models['Person']->isNewRecord)
// echo $form->field($models['Person'], 'user_id')->hiddenInput()->label(false)->error(false);
// echo Html::hiddenInput('step',$step);
//echo $form->errorSummary($models['Person']); 

?>
 
 
    
    <?php
    $configBtnWizard = ['step'=>$step,'formSteps'=>$this->context->formSteps,'id'=>$models['Person']->user_id];
    echo $this->render('btnWizard', $configBtnWizard); ?>
     
    
    <div class="sw-container tab-content">
        <div class="step-content" style="display:block;">
            <?= $this->render('_step-'.$step, ['models' => $models,'form'=>$form,'step'=>$step,'modals'=>$modals]); ?>
        </div>
    </div>
    
    <?= $this->render('btnWizard', $configBtnWizard); ?>
   
    

<?php ActiveForm::end(); ?>