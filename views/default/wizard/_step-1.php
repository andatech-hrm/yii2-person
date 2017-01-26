<h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
    <i class="<?= $this->context->formSteps[1]['icon']; ?>"></i> Step 1 
    <span class="text-muted"><?= $this->context->formSteps[1]['desc']; ?></span>
</h2> 
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