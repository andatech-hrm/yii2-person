<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Child */

$this->title = Yii::t('andahrm/person', 'Update {modelClass}: ', [
    'modelClass' => 'Child',
]) . $modelPerson->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Children'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelPerson->user_id, 'url' => ['view', 'user_id' => $modelPerson->user_id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/person', 'Update');
?>
<div class="child-update">

    <?= $this->render('_form', [
        'modelPerson' => $modelPerson,
        'modelsPeople' => $modelsPeople
    ]) ?>

</div>
