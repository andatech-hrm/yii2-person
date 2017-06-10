<h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
    <i class="<?= $this->context->formSteps[3]['icon']; ?>"></i> Step 3 
    <span class="text-muted"><?= $this->context->formSteps[3]['desc']; ?></span>
</h2> 
<!-- Begin People Father -->
<div class="panel panel-default">
    <div class="panel-body">
        <h4 class="page-header green" style="margin-top: 0"><?= Yii::t('andahrm/person', 'Father'); ?></h4>
        <?php echo $this->render('../_form-people', ['model' => $models['PeopleFather'], 'form' => $form]); ?>
    </div>
</div>
<!-- End People Father -->

<!-- Begin People Mother -->
<div class="panel panel-default">
    <div class="panel-body">
        <h4 class="page-header green" style="margin-top: 0"><?= Yii::t('andahrm/person', 'Mother'); ?></h4>
        <?php echo $this->render('../_form-people', ['model' => $models['PeopleMother'], 'form' => $form]); ?>
    </div>
</div>
<!-- End People Mother -->

<h4 class="page-header"><?= Yii::t('andahrm/person', 'Childs'); ?></h4>
<?php echo $this->render('_form-people-childs', ['models' => $models['PeopleChilds'], 'form' => $form]); ?>