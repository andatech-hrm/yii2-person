<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\person\models\PersonRetired */

$this->title = Yii::t('andahrm/person', 'Create Person Retired');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Person Retireds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-retired-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
