<?php
// use yii\helpers\ArrayHelper;
use andahrm\setting\models\WidgetSettings;
use kartik\widgets\Select2;


use andahrm\structure\models\FiscalYear;
use andahrm\leave\models\LeaveRelated;
use kartik\widgets\DepDrop;

use yii\helpers\Url;

?>


 <div class="row">
      <div class="col-sm-3">
        <?= $form->field($model, 'leave_related_id')->dropDownList(LeaveRelated::getList(),[
        'prompt'=>Yii::t('app','Select'),
        ]) ?>
      </div>
</div>  
    
    
 <div class="row">
        
      <div class="col-sm-3">
        <?= $form->field($model, 'year')->dropDownList(FiscalYear::getList(),[
        'prompt'=>Yii::t('app','Select'),
        ]) ?>
      </div>
      
      
      <div class="col-sm-3">
        <?= $form->field($model, 'number_day')->textInput([
        'placeholer'=>Yii::t('app','Select'),
        ]) ?>
      </div>
      
</div> 