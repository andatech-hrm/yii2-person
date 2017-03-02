<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Detail */

$this->title = Yii::t('andahrm', 'Update {modelClass}: ', [
    'modelClass' => 'Detail',
]) . $model->person->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
?>
<div class="detail-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelAddressContact' => $modelAddressContact,
        'modelAddressBirthPlace' => $modelAddressBirthPlace,
        'modelAddressRegister' => $modelAddressRegister,
        'form' => $form
    ]) ?>

</div>
