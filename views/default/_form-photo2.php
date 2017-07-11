<?php
use anda\core\widgets\cropimageupload\CropImageUpload;
?>
<?= $form->field($model, 'year')->widget(\andahrm\datepicker\YearBuddhist::className()) ?>
<?= $form->field($model, 'image')->widget(CropImageUpload::className()); ?>