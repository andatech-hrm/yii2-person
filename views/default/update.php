<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Person */

$this->title = Yii::t('andahrm', 'Update {modelClass}: ', [
    'modelClass' => 'Default',
]) . $models['person']->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Person'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $models['person']->user_id, 'url' => ['view', 'id' => $models['person']->user_id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
?>
<div class="person-update">

    <?= $this->render('_form', [
        'models' => $models,
    ]) ?>

</div>
