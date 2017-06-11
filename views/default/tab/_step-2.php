<h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
    <i class="<?= $this->context->formSteps[$step]['icon']; ?>"></i> Step <?=$step?> 
    <span class="text-muted"><?= $this->context->formSteps[$step]['desc']; ?></span>
</h2> 


<?php echo $this->render('../_form-person', ['model' => $models['Person'], 'modelUser' => $models['User'], 'form' => $form]); ?>

<?php /*
<h2 class="page-header dark"><?= Yii::t('andahrm/person', 'Photo'); ?></span></h2>
<div class="row">
<?php 
if($models['person']->isNewRecord) {
    echo '<div class="col-sm-3">';
    echo $this->render('../_form-photo', ['model' => $models['photo'], 'form' => $form]); 
    echo '</div>';
}else{
    foreach($models['person']->photos as $modelPhoto) {
    echo '<div class="col-sm-3">';
    echo $this->render('../_form-photo', ['model' => $modelPhoto, 'form' => $form]); 
    echo '</div>';
    }
}
?>
</div>
*/ ?>

<!--<h4 class="page-header dark">Detail</h4>-->
<hr />
<?php echo $this->render('../_form-detail', ['model' => $models['Detail'], 'modelSpouse' => $models['PeopleSpouse'], 'form' => $form]);    ?>

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
        <?php echo $this->render('../_form-address', ['model' => $models['AddressContact'], 'form' => $form]); ?>
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
        <?php echo $this->render('../_form-address', ['model' => $models['AddressRegister'], 'form' => $form]); ?>
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
        <?php echo $this->render('../_form-address', ['model' => $models['AddressBirthPlace'], 'form' => $form]); ?>
    </div>
</div>
<!-- End Address Birth Place -->


<?php $this->render('../_form-address-js'); ?>
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