<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use kuakling\smartwizard\Step;
?>
<?php
$modals['edoc'] = Modal::begin([
    'header' => Yii::t('andahrm/person', 'Edoc'),
    'size' => Modal::SIZE_LARGE
]);
// echo $this->render('@andahrm/edoc/views/default/_form', ['model' => new \andahrm\edoc\models\Edoc(), ]);
// echo Yii::$app->runAction('/edoc/default/create-ajax', ['formAction' => Url::to(['/edoc/default/create-ajax'])]);
// echo '<iframe src="" frameborder="0" style="width:100%; height: 100%;" id="iframe_edoc_create"></iframe>';
            
Modal::end();
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'role'=>"form",
        'data-toggle'=>"validator",
        'accept-charset'=>"utf-8",
        'novalidate'=>"true",
        'enctype' => 'multipart/form-data',
    ]
]); ?>
<?php
$wizardId = 'person-wizard';

$jsPersonWizard['btn'] = <<< JS
// Toolbar extra buttons
var btnFinish = $('<button></button>').html('<i class="fa fa-flag-checkered"></i> Finish')
    .addClass('btn btn-primary')
    .on('click', function(){
        $.each($('.step-content'), function(){
            if($(this).find('.has-error').length) {
                $('a[href="#'+$(this).prop('id')+'"]').addClass('error');
            }
        });
    });
    
var btnCancel = $('<button></button>').html('<i class="fa fa-times"></i> Cancel')
    .addClass('btn btn-default')
    .on('click', function(){ $('#{$wizardId}').smartWizard('reset'); });
JS;


$this->registerJs(implode("\n", $jsPersonWizard));
$wizardItems = [];
foreach ($this->context->formSteps as $key => $step) {
    $wizardItems[$step['name']] = [
       'icon' => $step['icon'],
        'label' => 'Step - '.$step['name'].' <br /><small>'.$step['desc'].'</small>',
        'content' => $this->render('_step-'.$key, ['models' => $models, 'modals' => $modals, 'form' => $form]) 
    ];
}
echo Step::widget([
    'id' => $wizardId,
    'isFormStep' => true,
    'widgetOptions' => [
        'theme' => 'default',
        //'showStepURLhash' => false,
        'autoAdjustHeight' => false,
        'anchorSettings' => [
            'enableAllAnchors' => $models['person']->isNewRecord ? false : true,
        ],
        'toolbarSettings' => [
            'toolbarPosition' => 'both',
            'toolbarExtraButtons' => new JsExpression("[btnFinish, btnCancel]"),
        ],
    ],
    'items' => $wizardItems,
]);
?>

<?php ActiveForm::end(); ?>


<?php

$jsWizardEvent['showStep'] = <<< JS
$('#person-wizard').on('showStep', function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
    //alert('You are on step '+stepNumber+' now');
    $('#{$form->id}').yiiActiveForm("resetForm");
    if(stepPosition === 'first'){
        $('#prev-btn').addClass('disabled');
    }else if(stepPosition === 'final'){
        $('#next-btn').addClass('disabled');
    }else{
        $('#prev-btn').removeClass('disabled');
        $('#next-btn').removeClass('disabled');
    }
});
JS;

$jsWizardEvent['leaveStep'] = <<< JS
$('#person-wizard').on('leaveStep', function(e, anchorObject, stepNumber, stepDirection) {
    var elmForm = $('#{$wizardId}-form-step-' + stepNumber);
    if(stepDirection === 'forward' && elmForm){
        var inputs = elmForm.find('*[id]:visible');
        data = $('#{$form->id}').data("yiiActiveForm");
        $.each(data.attributes, function(i, item) {
            this.status = 3;
        });
        $('#{$form->id}').yiiActiveForm("validate");
        if (elmForm.find(".has-error").length) {
            return false;
        }

    }
    return true;

});
JS;

$jsWizardEvent['validateCitizenId'] = <<< JS
// $('#$form->id').yiiActiveForm('add', {
//     id: 'person-citizen_id',
//     name: 'person-citizen_id',
//     container: '.field-person-citizen_id',
//     input: '#person-citizen_id',
//     error: '.help-block',
//     validate:  function (attribute, value, messages, deferred, \$form) {
//         console.log(attribute);
//         for(i=0, sum=0; i < 12; i++){
//             sum += parseFloat(value.charAt(i))*(13-i);
//         }
//         // if((11-sum%11)%10!=parseFloat(value.charAt(12))){
//         //     yii.validation.boolean(value, messages, {"message":"Citizen Id don't match"});
//         // }
//     }
// });
JS;

$this->registerJs(implode("\n", $jsWizardEvent));
?>

