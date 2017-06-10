<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Person */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$modal['edoc'] = Modal::begin([
    'header' => Yii::t('andahrm/person', 'Edoc'),
]);
echo 'sdkjfhskjdfs';
            
Modal::end();
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
    ]
]); ?>
<!-- Begin Step 1 -->
<div class="row">
    <div class="col-sm-6">
        <!-- Begin Person -->
        <div class="x_panel">
            <div class="x_title">
                <h2>Basic info</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <?php
                echo $this->render('_form-person', ['model' => $models['person'], 'modelUser' => $models['user'], 'form' => $form]);    
            ?>
            </div>
        </div>
        <!-- End Person -->
    </div>
    <div class="col-sm-6">
        <div class="x_panel">
            <div class="x_title">
                <h2>User Account</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <?php
                echo $this->render('_signup', ['model' => $models['user'], 'form' => $form]);    
            ?>
            </div>
        </div>
    </div>
</div>
<!-- End Step 1 -->

<!-- Begin Step 2 - Detail -->
<div class="x_panel">
    <div class="x_title">
        <h2>Detail</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php echo $this->render('_form-detail', ['model' => $models['detail'], 'modelSpouse' => $models['people-spouse'], 'form' => $form]);    ?>
    </div>
</div>
<!-- End Step 2 - Detail -->

<!-- Begin Step 3 Addresses-->
<div class="x_panel">
    <div class="x_title">
        <h2>Addresses</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <!-- Begin Address Contact -->
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="page-header green" style="margin-top: 0">Contact</h4>
                <?php echo $this->render('_form-address', ['model' => $models['address-contact'], 'form' => $form]); ?>
            </div>
        </div>
        <!-- End Address Contact -->
    </div>
         
    <div class="x_content">   
        <!-- Begin Address Register -->
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="page-header green" style="margin-top: 0">Register</h4>
                <?php echo $this->render('_form-address', ['model' => $models['address-register'], 'form' => $form]); ?>
            </div>
        </div>
        <!-- End Address Register -->
    </div>
         
    <div class="x_content"> 
            
        <!-- Begin Address Birth Place -->
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="page-header green" style="margin-top: 0">Birth Place</h4>
                <?php echo $this->render('_form-address', ['model' => $models['address-birth-place'], 'form' => $form]); ?>
            </div>
        </div>
        <!-- Begin Address Birth Place -->
        <?php $this->render('_form-address-js'); ?>
    </div> 
</div>
<!-- End Step 3 Addresses-->

<!-- Begin Step 4 Parent-->
<div class="x_panel">
    <div class="x_title">
        <h2>Parent</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <!-- Begin People Father -->
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="page-header green" style="margin-top: 0">Father</h4>
               <?php echo $this->render('_form-people', ['model' => $models['people-father'], 'form' => $form]); ?>
            </div>
        </div>
        <!-- End People Father -->
            
        <!-- Begin People Mother -->
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="page-header green" style="margin-top: 0">Mother</h4>
               <?php echo $this->render('_form-people', ['model' => $models['people-mother'], 'form' => $form]); ?>
            </div>
        </div>
        <!-- End People Mother -->
    </div>
</div>
<!-- End Step 4 Parent-->

<!-- Begin Step 5 Childs-->
<?php echo $this->render('_form-people-childs', ['models' => $models['people-childs'], 'form' => $form]); ?>

<!-- End Step 5 Childs-->


<div class="ln_solid"></div>
<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button type="submit" class="btn btn-primary">Cancel</button>
        <button type="submit" class="btn btn-success">Submit</button>
    </div>
</div>
<?php ActiveForm::end(); ?>


<div class="x_panel">
    <div class="x_title">
        <h2>Person</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        
    </div>
</div>