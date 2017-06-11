<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<?php echo $this->render('../_form-register', [
    'model' => $models['Person'],
    'modelUser' => $models['User'], 
    'form' => $form,
    'step' => $step
]); ?>

