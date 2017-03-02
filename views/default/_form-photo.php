<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use anda\core\widgets\cropimageupload\CropImageUpload;
?>
<div class="form-group-image-crop">
<?= $form->field($model, 'year')->widget(\kuakling\datepicker\YearBuddhist::className()) ?>
<div style="width:100px;height:100px;overflow:hidden;margin-left:5px; background:#cfcfcf">
<?= Html::img($model->getUploadUrl('image_cropped'), ['class' => 'img-responsive img-cropped-preview', 'id' => 'preview']); ?>
</div>
<?php
$modal = Modal::begin([
    'header' => Html::tag('h2', ($model->person) ? $model->person->fullname : null),
    'toggleButton' => [
        'label' => Yii::t('andahrm/person', 'Choose photo'),
        'class' => 'btn btn-default'
    ],
    'options' => [
        'class' => 'modal-cropimage fade'
    ]
]);
?>
<?= $form->field($model, 'image')->widget(CropImageUpload::className()); ?>
<?php Modal::end(); ?>
</div>
<?php
$inputImageCrop = Html::getInputId($model, 'image_crop'); 
?>
<?php
$js[] = <<< JS
$('.modal-cropimage').on('hidden.bs.modal', function (e) {
    var img_crop = $(this).find('.crop-image-upload-container>img');
    // var img_preview = $(this).closest('.form-group-image-crop').find('>img');
    var img_preview = $('#preview');
    img_preview.attr('src', img_crop.prop('src'));
    
    // var offset_text = $('#{$inputImageCrop}').val();
    // var offset_array = offset_text.split("-");
});

JS;

$this->registerJs(implode("\n", $js));