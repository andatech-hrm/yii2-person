<h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
    <i class="<?= $this->context->formSteps[1]['icon']; ?>"></i> Step 1 
    <span class="text-muted"><?= $this->context->formSteps[1]['desc']; ?></span>
</h2>

<?php echo $this->render('../_form-person', ['model' => $models['person'], 'modelUser' => $models['user'], 'form' => $form]); ?>


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

<!--<h4 class="page-header dark">Detail</h4>-->
<hr />
<?php echo $this->render('../_form-detail', ['model' => $models['detail'], 'modelSpouse' => $models['people-spouse'], 'form' => $form]);    ?>

<h2 class="page-header dark"><?= Yii::t('andahrm/person', 'Address'); ?></span></h2>
<!-- Begin Address Contact -->
<div class="panel panel-default">
    <div class="panel-body">
        <h4 class="page-header green" style="margin-top: 0"><?= Yii::t('andahrm/person', 'Contact'); ?></h4>
        <?php echo $this->render('../_form-address', ['model' => $models['address-contact'], 'form' => $form]); ?>
    </div>
</div>
<!-- End Address Contact -->

<!-- Begin Address Register -->
<div class="panel panel-default">
    <div class="panel-body">
        <h4 class="page-header green" style="margin-top: 0"><?= Yii::t('andahrm/person', 'Register'); ?></h4>
        <?php echo $this->render('../_form-address', ['model' => $models['address-register'], 'form' => $form]); ?>
    </div>
</div>
<!-- End Address Register -->

<!-- Begin Address Birth Place -->
<div class="panel panel-default">
    <div class="panel-body">
        <h4 class="page-header green" style="margin-top: 0"><?= Yii::t('andahrm/person', 'Birth Place'); ?></h4>
        <?php echo $this->render('../_form-address', ['model' => $models['address-birth-place'], 'form' => $form]); ?>
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