<?php
use anda\core\widgets\cropimageupload\CropImageUpload;
?>
<?= $form->field($model, 'year')->widget(\kuakling\datepicker\YearBuddhist::className()) ?>
<?= $form->field($model, 'image')->widget(CropImageUpload::className()); ?>