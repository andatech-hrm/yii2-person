

<?= $this->render('../_form-position-salary', [
    'dataProvider' => $models['dataProvider'],
    'dataProviderContract' => $models['dataProviderContract'],
    'user_id'=>$models['Person']->user_id,
    'form' => $form,
    'modals'=>$modals,
    'step'=>$step
]); ?>