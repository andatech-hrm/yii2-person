<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Defect */

$this->title = Yii::t('andahrm', 'Update') .' '. $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Defects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/person', 'Update');
?>
<div class="defect-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
