<h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
    <i class="<?= $this->context->formSteps[2]['icon']; ?>"></i> Step 2 
    <span class="text-muted"><?= $this->context->formSteps[2]['desc']; ?></span>
</h2> 
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
<!-- End Address Birth Place -->


<?php $this->render('../_form-address-js'); ?>