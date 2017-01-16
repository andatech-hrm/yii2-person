<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use karpoff\icrop\CropImageUpload;
use anda\core\widgets\cropimageupload\CropImageUpload;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Photo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="photo-form">

    <?php $form = ActiveForm::begin([
//         'action' => ($model->isNewRecord) ? ['create'] : ['update', 'user_id' => $model->user_id, 'year' => $model->year],
        'options' => [
            'enctype' => 'multipart/form-data',
        ]
    ]); ?>

    <?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>
    <?php echo $form->field($model, 'image')->widget(CropImageUpload::className()); ?>
    <hr>
    <div class="form-group pull-right">
        <?php $btnText = $model->isNewRecord ? Yii::t('andahrm/structure', 'Create') : Yii::t('andahrm/structure', 'Update'); ?>
        <?= Html::submitButton('<i class="fa fa-check-circle-o" aria-hidden="true"></i> '.$btnText, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
