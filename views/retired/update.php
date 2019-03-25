<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\PersonRetired */

$this->title = Yii::t('andahrm/person', 'Update Person Retired: ' . $model->user_id, [
    'nameAttribute' => '' . $model->user_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Person Retireds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/person', 'Update');
?>
<div class="person-retired-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
