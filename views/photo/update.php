<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Photo */

$this->title = Yii::t('andahrm/structure', 'Update {modelClass}: ', [
    'modelClass' => 'Photo',
]) . $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Photos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'user_id' => $model->user_id, 'year' => $model->year]];
$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
?>
<div class="photo-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
