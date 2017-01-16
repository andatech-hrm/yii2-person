<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Person */

$this->title = Yii::t('app', 'Create Person');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelUser' => $modelUser,
    ]) ?>

</div>
