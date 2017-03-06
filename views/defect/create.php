<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Defect */

$this->title = Yii::t('andahrm', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Defects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="defect-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
