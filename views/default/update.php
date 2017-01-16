<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Person */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Default',
]) . $model->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="person-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelUser' => $modelUser,
    ]) ?>

</div>
