<?php
use yii\bootstrap\ActiveForm;
?>
<?php
$formSteps = $this->context->formSteps;
$stepNumber = 0;
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'role'=>"form",
        'data-toggle'=>"validator",
        'accept-charset'=>"utf-8",
        'novalidate'=>"true"
    ]
]); ?>
<div id="smartwizard" class="sw-main sw-theme-dots">
    <ul class="nav nav-tabs step-anchor">
        <?php foreach ($formSteps as $key => $formStep) : ?>
        <li<?= ($this->context->action->id === 'create') ? '' : ' class="done"'; ?>><a href="#step-<?= $key; ?>">Step - <?= $formStep['name']; ?><br /><small><?= $formStep['desc']; ?></small></a></li>
        <?php endforeach; ?>
    </ul>

    <div class="sw-container tab-content">
       <!-- Begin Step 1 -->
        <div id="step-1" class="step-content" style="display: block;"><div id="form-step-<?= $stepNumber++; ?>">
            <h2 class="page-header dark">Step 1 <span class="text-muted"><?= $formSteps[1]['desc']; ?></span></h2> 
            <div class="row">
                <div class="col-sm-6">
                    <!-- Begin Person -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4 class="page-header green panel-title-address" style="margin-top: 0">Basic</h4>
                            <div class="clearfix"></div>
                            <?php echo $this->render('../_form-person', ['model' => $models['person'], 'modelUser' => $models['user'], 'form' => $form]); ?>
                        </div>
                    </div>
                    <!-- End Person -->
                </div>
                <div class="col-sm-6">
                    <!-- Begin User account -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4 class="page-header green panel-title-address" style="margin-top: 0">User Account</h4>
                            <div class="clearfix"></div>
                            <?php echo $this->render('../_signup', ['model' => $models['user'], 'form' => $form]); ?>
                        </div>
                    </div>
                    <!-- End User account -->
                </div>
            </div>
            </div></div>
        <!-- End Step 1 -->
        
        <div id="step-2" class="step-content"><div id="form-step-<?= $stepNumber++; ?>">
            <h2 class="page-header dark">Step 2 <span class="text-muted"><?= $formSteps[2]['desc']; ?></span></h2> 
            <?php echo $this->render('../_form-detail', ['model' => $models['detail'], 'modelSpouse' => $models['people-spouse'], 'form' => $form]);    ?>
            
            <h2 class="page-header dark">Address</span></h2>
            <!-- Begin Address Contact -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="page-header green" style="margin-top: 0">Contact</h4>
                    <?php echo $this->render('../_form-address', ['model' => $models['address-contact'], 'form' => $form]); ?>
                </div>
            </div>
            <!-- End Address Contact -->
            
            <!-- Begin Address Register -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="page-header green" style="margin-top: 0">Register</h4>
                    <?php echo $this->render('../_form-address', ['model' => $models['address-register'], 'form' => $form]); ?>
                </div>
            </div>
            <!-- End Address Register -->
            
            <!-- Begin Address Birth Place -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="page-header green" style="margin-top: 0">Birth Place</h4>
                    <?php echo $this->render('../_form-address', ['model' => $models['address-birth-place'], 'form' => $form]); ?>
                </div>
            </div>
            <!-- Begin Address Birth Place -->
            <?php $this->render('../_form-address-js'); ?>
        </div></div>
        
        
        <div id="step-3" class="step-content"><div id="form-step-<?= $stepNumber++; ?>">
            <h2 class="page-header dark">Step 3 <span class="text-muted"><?= $formSteps[3]['desc']; ?></span></h2> 
            <!-- Begin People Father -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="page-header green" style="margin-top: 0">Father</h4>
                   <?php echo $this->render('../_form-people', ['model' => $models['people-father'], 'form' => $form]); ?>
                </div>
            </div>
            <!-- End People Father -->

            <!-- Begin People Mother -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="page-header green" style="margin-top: 0">Mother</h4>
                   <?php echo $this->render('../_form-people', ['model' => $models['people-mother'], 'form' => $form]); ?>
                </div>
            </div>
            <!-- End People Mother -->
            
            </div></div>
        
        
        <div id="step-4" class="step-content"><div id="form-step-<?= $stepNumber++; ?>">
            <h2 class="page-header dark">Step 4 <span class="text-muted"><?= $formSteps[4]['desc']; ?></span></h2> 
            <?php echo $this->render('_form-people-childs', ['models' => $models['people-childs'], 'form' => $form]); ?>
        </div></div>
    </div>
</div>

<?php ActiveForm::end(); ?>
        
        

<?php
$enableAllAnchors = ($this->context->action->id === 'create') ? 'false' : 'true';
$js['wizard'] = <<< JS
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
    .on('click', function(){ $('#smartwizard').smartWizard('reset'); });
    
$('#smartwizard').smartWizard({ 
    selected: 0, 
    theme: 'arrows',
    transitionEffect:'fade',
    showStepURLhash: false,
    autoAdjustHeight: false,
    anchorSettings: {
        enableAllAnchors: $enableAllAnchors,
    },
    toolbarSettings: {toolbarPosition: 'both',
        toolbarExtraButtons: [btnFinish, btnCancel]
    }
});

$('#smartwizard').on('showStep', function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
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

$('#smartwizard').on('leaveStep', function(e, anchorObject, stepNumber, stepDirection) {
    var elmForm = $('#form-step-' + stepNumber);
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

$this->registerJs(implode("\n", $js));
$this->registerJsFile("http://techlaboratory.net/demos/SmartWizard4/js/jquery.smartWizard.min.js", ['depends' => 'yii\bootstrap\BootstrapPluginAsset']);
$this->registerCssFile("http://techlaboratory.net/demos/SmartWizard4/css/smart_wizard.css");
$this->registerCssFile("http://techlaboratory.net/demos/SmartWizard4/css/smart_wizard_theme_arrows.css");
 ?>