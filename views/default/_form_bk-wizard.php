<?php
use yii\bootstrap\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
<?php
$wizard_config = [
    'id' => 'stepwizard',
    'default_buttons' => [
        'prev' => ['title' => '<i class="fa fa-arrow-left"></i> Previous', 'options' => [ 'class' => 'btn btn-primary', 'type' => 'button']],
        'next' => ['title' => 'Next <i class="fa fa-arrow-right"></i>', 'options' => [ 'class' => 'btn btn-success', 'type' => 'button']],
        'save' => ['title' => '<i class="fa fa-check"></i> Save', 'options' => [ 'class' => 'btn btn-success', 'type' => 'submit']],
        'skip' => ['title' => 'Skip', 'options' => [ 'class' => 'btn btn-default', 'type' => 'button']],
    ],
    'steps' => [
        1 => [
            'title' => 'Step 1 Basic',
            'icon' => 'fa fa-user-circle',
            'content' => $this->render('_form-person', [
                'model' => $models['person'],
                'modelUser' => $models['user'],
                'form' => $form,
                'roleList' => $models['person']->getRoleList()
            ]),
        ],
        2 => [
            'title' => 'Step 2 Detail',
            'icon' => 'fa fa-info-circle',
            'content' => $this->render('_form-detail', [
                'model' => $models['detail'],
                'form' => $form,
            ]),
            'skippable' => true,
        ],
        3 => [
            'title' => 'Step 3 Addresses',
            'icon' => 'fa fa-map-marker',
            'content' => '<div class="row">' . 
                '<div class="col-sm-4">' .
                '<h4 class="green">Contact</h4>' .
                $this->render('_form-address', [
                'model' => $models['address-contact'],
                'form' => $form,
                ]) .
                '</div>' . 
                '<div class="col-sm-4">' .
                '<h4 class="green">Register</h4>' .
                $this->render('_form-address', [
                'model' => $models['address-register'],
                'form' => $form,
                ]) .
                '</div>' . 
                '<div class="col-sm-4">' .
                '<h4 class="green">Birth Place</h4>' .
                $this->render('_form-address', [
                'model' => $models['address-birth-place'],
                'form' => $form,
                ]) .
                '</div>' .
                '</div>',
            'skippable' => true,
        ],
        4 => [
            'title' => 'Step 4 Parents',
            'icon' => 'fa fa-user-secret',
            'content' => '<div class="row">' . 
                '<div class="col-sm-6">' .
                '<h4 class="green">Father</h4>' .
                $this->render('_form-people', [
                'model' => $models['people-father'],
                'form' => $form,
                ]) .
                '</div>' . 
                '<div class="col-sm-6">' .
                '<h4 class="green">Mother</h4>' .
                $this->render('_form-people', [
                'model' => $models['people-mother'],
                'form' => $form,
                ]) .
                '</div>' . 
                '</div>',
            'skippable' => true,
        ],
    ],
    //'complete_content' => "You are done!", // Optional final screen
//     'start_step' => 2, // Optional, start with a specific step
];
?>

<?= \drsdre\wizardwidget\WizardWidget::widget($wizard_config); ?>
<?php ActiveForm::end(); ?>


<?= $this->render('_form-address-js'); ?>