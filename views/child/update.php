<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Child */

$this->title = Yii::t('andahrm/person', 'Update {modelClass}: ', [
    'modelClass' => 'Child',
]) . $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Children'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'user_id' => $model->user_id, 'people_id' => $model->people_id, 'relation' => $model->relation]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/person', 'Update');
?>
<div class="child-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelPeople' => $modelPeople,
        'modelPerson' => $modelPerson,
    ]) ?>

</div>
