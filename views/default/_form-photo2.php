<?php
use anda\core\widgets\cropimageupload\CropImageUpload;
?>
<?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'image')->widget(CropImageUpload::className()); ?>