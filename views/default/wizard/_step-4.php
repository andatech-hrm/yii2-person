<h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
    <i class="<?= $this->context->formSteps[4]['icon']; ?>"></i> Step 4 
    <span class="text-muted"><?= $this->context->formSteps[4]['desc']; ?></span>
</h2> 
<?php echo $this->render('_form-people-childs', ['models' => $models['people-childs'], 'form' => $form]); ?>