<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Photo */

$this->title = Yii::t('andahrm/structure', 'Create Photo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Photos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
