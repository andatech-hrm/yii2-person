<h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
    <i class="<?= $this->context->formSteps[1]['icon']; ?>"></i> Step 1 
    <span class="text-muted"><?= $this->context->formSteps[1]['desc']; ?></span>
</h2>

<?php echo $this->render('../_form-register', [
    'model' => $models['person'],
    'modelUser' => $models['user'], 
    'form' => $form
]); ?>
