<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Person */

$this->title = Yii::t('app', 'Create Person');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$formSteps = $this->context->formSteps;
?>
<?php /*
<div id="wizard" class="form_wizard wizard_horizontal">
    <ul class="wizard_steps anchor">
        <?php foreach ($formSteps as $key => $formStep) : ?>
        <li>
            <a href="#step-<?= $key; ?>" class="<?= ($key == 1) ? 'selected' : 'disabled'; ?>" isdone="0" rel="<?= $key; ?>">
                <span class="step_no"><?= $formStep['name']; ?></span>
                <span class="step_descr"><?= $formStep['desc']; ?></span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
        
    <div class="stepContainer">
        <?php $form = ActiveForm::begin(); ?>
        <div id="step-1" class="content" style="display: block;">
            <div class="row">
                <div class="col-sm-6">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Default <small>Hover to view</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <?= $this->render('_form-person', [
                            'model' => $models['person'],
                            'modelUser' => $models['user'],
                            'form' => $form,
                            ]); ?>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>User Account <small>Hover to view</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <?php 
                            echo $this->render('_signup', [
                                'model' => $models['user'],
                                'form' => $form,
                                'roleList' => $models['person']->getRoleList()
                            ]); 
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="step-2" class="content" style="display: none;">
            <h2 class="StepTitle">Step 2 Content</h2>
            <?= $this->render('_form-detail', [
                        'model' => $models['detail'],
                        'modelSpouse' => $models['people-spouse'],
                        'form' => $form,
                    ]); ?>
        </div>
        <div id="step-3" class="content" style="display: none;">
            <h2 class="StepTitle">Step 3 Content</h2>
            <p>
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
                eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
        </div>
        <div id="step-4" class="content" style="display: none;">
            <h2 class="StepTitle">Step 4 Content</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
        </div>
    <?php ActiveForm::end(); ?>
    </div> 
<!--     <div class="actionBar">
        <div class="msgBox">
            <div class="content"></div>
            <a href="#" class="close">X</a>
        </div>
        <div class="loader">Loading</div>
        <a href="#" class="buttonPrevious buttonDisabled btn btn-primary">Previous</a>
        <a href="#" class="buttonNext btn btn-success">Next</a>
        <a href="#" class="buttonFinish buttonDisabled btn btn-default">Finish</a>
    </div> -->
</div>
<?php 
$js[] = <<< JS
$('#wizard').smartWizard({
    transitionEffect:'slideleft',
    onLeaveStep:leaveAStepCallback,
});
$('.buttonNext').addClass('btn btn-success');
$('.buttonPrevious').addClass('btn btn-primary');
$('.buttonFinish').addClass('btn btn-default');

$('.buttonNext').click(function(){
    alert('click');
});

function leaveAStepCallback(obj){
    alert('leave');
    var step_num= obj.attr('rel');
    var jStep = $('#step-'+step_num);
    var inputs = jStep.find('*[id]:visible');
    $.each(inputs, function(i, item){
        $('#{$form->id}').yiiActiveForm('validateAttribute', this.id);
    });
    
    if ($('#{$form->id}').find(".has-error").length) {
        return false;
    }
    return true;
}
JS;
$this->registerJs(implode("\n", $js));
$this->registerJsFile('http://mstratman.github.io/jQuery-Smart-Wizard/js/jquery.smartWizard.js', ['depends' => 'yii\bootstrap\BootstrapPluginAsset']);
*/ ?>


<?php $form = ActiveForm::begin([
    'options' => [
        'role'=>"form",
        'data-toggle'=>"validator",
        'accept-charset'=>"utf-8",
        'novalidate'=>"true"
    ]
]); ?>
<!-- SmartWizard html -->
<div id="smartwizard">
    <ul>
        <?php foreach ($formSteps as $key => $formStep) : ?>
        <li><a href="#step-<?= $key; ?>">Step <?= $formStep['name']; ?><br /><small><?= $formStep['desc']; ?></small></a></li>
        <?php endforeach; ?>
    </ul>

    <div>
        <?php $stepNumber = 0; ?>
        <div id="step-1" class="container-fluid">
            <h2>Step 1 Content</h2>
            <div class="row" id="form-step-<?= $stepNumber++; ?>" role="form" data-toggle="validator">
                <div class="col-sm-6">
                    <?= $this->render('_form-person', [
                        'model' => $models['person'],
                        'modelUser' => $models['user'],
                        'form' => $form,
                        ]); ?>
                </div>
                <div class="col-sm-6">
                    <?php 
                    echo $this->render('_signup', [
                        'model' => $models['user'],
                        'form' => $form,
                        'roleList' => $models['person']->getRoleList()
                    ]); 
                    ?>
                </div>
            </div>
        </div>
        <div id="step-2" class="">
            <h2>Step 2 Content</h2>
            <div class="row" id="form-step-<?= $stepNumber++; ?>" role="form" data-toggle="validator">
                <div class="col-sm-6">
                    <?= $this->render('_form-detail', [
                        'model' => $models['detail'],
                        'modelSpouse' => $models['people-spouse'],
                        'form' => $form,
                    ]); ?>
                </div>
            </div>
        </div>
        <div id="step-3" class="">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has
            survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
            publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
            printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the
            release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
            typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of
            Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a
            type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
            and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever
            since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised
            in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and
            typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also
            the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker
            including versions of Lorem Ipsum.
        </div>
        <div id="step-4" class="">
            <h2>Step 4 Content</h2>
            <div class="panel panel-default">
                <div class="panel-heading">My Details</div>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Name:</th>
                            <td>Tim Smith</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>example@example.com</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
                <?php ActiveForm::end(); ?>
        
        

<?php
$js['wizard'] = <<< JS
// Toolbar extra buttons
var btnFinish = $('<button></button>').text('Finish')
    .addClass('btn btn-info')
    .on('click', function(){ alert('Finish Clicked'); });
    
var btnCancel = $('<button></button>').text('Cancel')
    .addClass('btn btn-danger')
    .on('click', function(){ $('#smartwizard').smartWizard('reset'); });
    
$('#smartwizard').smartWizard({ 
    selected: 0, 
    theme: 'default',
    transitionEffect:'fade',
    toolbarSettings: {toolbarPosition: 'both',
        toolbarExtraButtons: [btnFinish, btnCancel]
    }
});

$('#smartwizard').on('showStep', function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
    //alert('You are on step '+stepNumber+' now');
    if(stepPosition === 'first'){
        $('#prev-btn').addClass('disabled');
    }else if(stepPosition === 'final'){
        $('#next-btn').addClass('disabled');
    }else{
        $('#prev-btn').removeClass('disabled');
        $('#next-btn').removeClass('disabled');
    }
});

$('#smartwizard').on('leaveStep', function(e, anchorObject, stepNumber, stepDirection) {
    var elmForm = $('#form-step-' + stepNumber);
    if(stepDirection === 'forward' && elmForm){
        var inputs = elmForm.find('*[id]:visible');
        data = $('#{$form->id}').data("yiiActiveForm");
        $.each(data.attributes, function(i, item) {
            this.status;
            this.status = 3;
        });
        $('#{$form->id}').yiiActiveForm("validate");
        if ($('#{$form->id} .step-content').find(".has-error").length) {
            return false;
        }

    }
    return true;

});



JS;

$this->registerJs(implode("\n", $js));
$this->registerJsFile("http://techlaboratory.net/demos/SmartWizard4/js/jquery.smartWizard.min.js", ['depends' => 'yii\bootstrap\BootstrapPluginAsset']);
$this->registerCssFile("http://techlaboratory.net/demos/SmartWizard4/css/smart_wizard.css");
 ?>
