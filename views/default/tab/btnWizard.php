<?php
/*
use yii\helpers\Html;

//echo $step;

$disabled = ($step==1)?' disabled':'';
$disabledNext = ($step == count($formSteps))?' disabled':'';
?>

<nav class="navbar btn-toolbar sw-toolbar sw-toolbar-top">
    <div class="btn-group navbar-btn sw-btn-group-extra pull-right" role="group">
        <?= Html::submitButton('<i class="fa fa-flag-checkered"></i> '.Yii::t('andahrm', 'Finish'), ['name'=>'finish','class' => 'btn btn-primary'.$disabled]) ?>
        <?= Html::a('<i class="fa fa-times"></i> '.Yii::t('andahrm', 'Cancel'),['/person'],['class'=>'btn btn-default']);?>
    </div>
    
    <div class="btn-group navbar-btn sw-btn-group pull-right" role="group">
         <?= Html::a('<i class="fa fa-arrow-left "></i> '.Yii::t('andahrm', 'Prev'),['create','step'=>($step-1),'id'=>$id],
             ['class'=>'btn btn-default sw-btn-prev'.$disabled]);?>
         <?= Html::submitButton(Yii::t('andahrm', 'Next').' <i class="fa fa-arrow-right "></i>', ['name'=>'next','value'=>'next', 'class' => 'btn btn-default btn-success'.$disabledNext]); ?>
    </div>
</nav>



<?php
*/

use yii\helpers\Html;

//echo $step;
$disabledFinish = ($step==1)?' disabled':'';
$btnFinishOptin['name']='finish';
$btnFinishOptin['value']='finish';
$btnFinishOptin['class']='btn btn-primary '.$disabledFinish;
if($disabledFinish)
$btnFinishOptin['disabled']=$disabledFinish;

$disabledPrev = ($step==1)?' disabled':'';
$btnPrevOptin['name']='prev';
$btnPrevOptin['value']='prev';
$btnPrevOptin['class']='btn btn-default '.$disabledPrev;
if($disabledPrev)
$btnPrevOptin['disabled']=$disabledPrev;

$disabledNext = $step == count($formSteps)?'disabled':'';
$btnNextOptin['name']='next';
$btnNextOptin['value']='next';
$btnNextOptin['class']='btn btn-success'.$disabledNext;
if($disabledNext)
$btnNextOptin['disabled']=$disabledNext;

$disabledSave = $step == count($formSteps)?'disabled':'';
$btnSaveOptin['name']='save';
$btnSaveOptin['value']='save';
$btnSaveOptin['class']='btn btn-default'.$disabledSave;
if($disabledSave)
$btnNextOptin['disabled']=$disabledSave;

?>
<nav class="navbar btn-toolbar sw-toolbar sw-toolbar-top">
    <div class="btn-group navbar-btn sw-btn-group-extra pull-right" role="group">
        <?= Html::submitButton('<i class="fa fa-flag-checkered"></i> '.Yii::t('andahrm', 'Finish'), $btnFinishOptin) ?>
        <?= Html::a('<i class="fa fa-times"></i> '.Yii::t('andahrm', 'Cancel'),['/person'],['class'=>'btn btn-default']);?>
    </div>
    
    <div class="btn-group navbar-btn sw-btn-group pull-right" role="group">
         <?= Html::submitButton('<i class="fa fa-arrow-left "></i> '.Yii::t('andahrm', 'Prev'), $btnPrevOptin); ?>
         <?= Html::submitButton('<i class="fa fa-floppy-o"></i> '.Yii::t('andahrm', 'Save'), $btnSaveOptin); ?>
         <?= Html::submitButton(Yii::t('andahrm', 'Next').' <i class="fa fa-arrow-right "></i>', $btnNextOptin); ?>
    </div>
</nav>

    