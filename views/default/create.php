<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Person */

$this->title = Yii::t('andahrm', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Person'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php
    echo $this->render('_form', ['models' => $models]);
