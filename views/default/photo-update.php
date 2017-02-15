<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
    ]
]); ?>

<?php echo $this->render('_form-photo2', ['model' => $model, 'form' => $form]); ?>

<div class="pull-right">
<?php 
echo Html::resetButton('<i class="fa fa-recycle"></i> Reset', ['class' => 'btn btn-default']) . Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-primary btn-modal-save'])
?>
</div>
<div class="clearfix"></div>

<?php ActiveForm::end(); ?>