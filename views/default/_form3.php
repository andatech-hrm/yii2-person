<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;
use andahrm\person\models\Title;
use andahrm\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Person */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
  $formOptions['options'] = [
    'data-pjax' => '',
    'enctype' => 'multipart/form-data',
    ];
  //$formOptions['layout'] = 'horizontal';
  $formOptions['fieldConfig'] = [
                //'template' => "{label}\n{beginWrapper}\n{input}\n{error}\n{hint}\n{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-3',
                    //'offset' => 'col-sm-offset-2',
                    'wrapper' => 'col-sm-7',
                    //'error' => 'col-sm-12',
                    //'hint' => '',
                ],
            ];
  //if($formAction !== null)  $formOptions['action'] = $formAction;
  
  $form = ActiveForm::begin($formOptions); 
?>
 
 <div class="x_panel">
    <div class="x_title">
        <h2>Person</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        
        
        <ul class="nav nav-pills ">
            <li><a href="#tab-1" data-toggle="tab" class="scroll">Tab 1</a>
        
        
        <h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
            <i class="<?= $this->context->formSteps[1]['icon']; ?>"></i> Step 1 
            <span class="text-muted"><?= $this->context->formSteps[1]['desc']; ?></span>
        </h2>

<?php echo $this->render('_form-person', ['model' => $models['person'], 'modelUser' => $models['user'], 'form' => $form]); ?>

<hr />
<?php #echo $this->render('_form-detail', ['model' => $models['detail'], 'modelSpouse' => $models['people-spouse'], 'form' => $form]);    ?>

<h2 class="page-header dark"><?= Yii::t('andahrm/person', 'Address'); ?></span></h2>
<?php
    $btnCopyAddr = [
        'contact' => '<button class="btn btn-default btn-xs btn-copy" data-from="contact">'.Yii::t('andahrm/person', 'Contact').'</button>',
        'register' => '<button class="btn btn-default btn-xs btn-copy" data-from="register">'.Yii::t('andahrm/person', 'Register').'</button>',
        'birth-place' => '<button class="btn btn-default btn-xs btn-copy" data-from="birth-place">'.Yii::t('andahrm/person', 'Birth Place').'</button>',
    ];
    $btnCopyLabel = 'คัดลอกจาก: ';
?>
<!-- Begin Address Contact -->
<div class="panel panel-default" id="address-contact">
    <div class="panel-body">
        <div class="pull-right">
            <?= $btnCopyLabel; ?>
            <div class="btn-group" role="group" aria-label="...">
            <?= $btnCopyAddr['register']; ?>
            <?= $btnCopyAddr['birth-place']; ?>
            </div>
        </div>
        <h4 class="page-header green" style="margin-top: 0"><?= Yii::t('andahrm/person', 'Contact'); ?></h4>
        <?php echo $this->render('_form-address', ['model' => $models['address-contact'], 'form' => $form]); ?>
    </div>
</div>
<!-- End Address Contact -->

<!-- Begin Address Register -->
<div class="panel panel-default" id="address-register">
    <div class="panel-body">
        <div class="pull-right">
            <?= $btnCopyLabel; ?>
            <div class="btn-group" role="group" aria-label="...">
            <?= $btnCopyAddr['contact']; ?>
            <?= $btnCopyAddr['birth-place']; ?>
            </div>
        </div>
        <h4 class="page-header green" style="margin-top: 0"><?= Yii::t('andahrm/person', 'Register'); ?></h4>
        <?php echo $this->render('_form-address', ['model' => $models['address-register'], 'form' => $form]); ?>
    </div>
</div>
<!-- End Address Register -->

<!-- Begin Address Birth Place -->
<div class="panel panel-default" id="address-birth-place">
    <div class="panel-body">
        <div class="pull-right">
            <?= $btnCopyLabel; ?>
            <div class="btn-group" role="group" aria-label="...">
            <?= $btnCopyAddr['contact']; ?>
            <?= $btnCopyAddr['register']; ?>
            </div>
        </div>
        <h4 class="page-header green" style="margin-top: 0"><?= Yii::t('andahrm/person', 'Birth Place'); ?></h4>
        <?php echo $this->render('_form-address', ['model' => $models['address-birth-place'], 'form' => $form]); ?>
    </div>
</div>
<!-- End Address Birth Place -->


<?php $this->render('_form-address-js'); ?>
<?php /*<div class="row">
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
</div>*/ ?>

    </div>
</div>
<?php ActiveForm::end(); ?>



        
