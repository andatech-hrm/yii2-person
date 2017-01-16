<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Child */

$this->title = Yii::t('andahrm/person', 'Create Child').': '.$modelPerson->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Children'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="child-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelPeople' => $modelPeople,
        'modelPerson' => $modelPerson,
    ]) ?>

</div>
