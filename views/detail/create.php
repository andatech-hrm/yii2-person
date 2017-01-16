<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Detail */

$this->title = Yii::t('andahrm/person', 'Create Detail');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detail-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelAddressContact' => $modelAddressContact,
        'modelAddressBirthPlace' => $modelAddressBirthPlace,
        'modelAddressRegister' => $modelAddressRegister,
        'form' => $form
    ]) ?>

</div>
