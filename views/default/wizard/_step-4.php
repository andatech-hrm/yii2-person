<h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
    <i class="<?= $this->context->formSteps[4]['icon']; ?>"></i> Step 4 
    <span class="text-muted"><?= $this->context->formSteps[4]['desc']; ?></span>
</h2> 
<?= $this->render('../_form-position-salary', ['model' => $models['position-salary'], 'modelContract' => $models['contract'], 'modals' => $modals, 'form' => $form]); ?>