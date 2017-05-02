<?php
// use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;
use andahrm\setting\models\WidgetSettings;
use kartik\widgets\Select2;
use kuakling\datepicker\DatePicker;


use andahrm\structure\models\FiscalYear;
use andahrm\leave\models\LeaveRelated;
use kartik\widgets\DepDrop;

use yii\helpers\Url;

?>

<div class="row">
  <div class="col-sm-12">
    <?php
    echo Html::radioList('personType', null, ['ข้าราชการ/ลูกจ้างประจำ', 'พนักงงานสัญญาจ้าง'],
    [
      'id' => 'person-type'
    ]
    );
    ?>
  </div>
  <div id="form_servant" style="display: none;">
    <?= $form->field($modelServant, 'start_date', ['options' => ['class' => 'form-group col-sm-4']])->widget(DatePicker::classname(), WidgetSettings::DatePicker()) ?>
    <?= $form->field($modelServant, 'end_date', ['options' => ['class' => 'form-group col-sm-4']])->widget(DatePicker::classname(), WidgetSettings::DatePicker()) ?>
    <?= $form->field($modelServant, 'work_date', ['options' => ['class' => 'form-group col-sm-4']])->widget(DatePicker::classname(), WidgetSettings::DatePicker()) ?>
  </div>
</div>

<hr />
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



<?php

$js[] = <<< JS
$(document).on('change', '#person-type input:radio', function(e){
    if($(this).val() == 0) {
        $('#form_servant').slideDown();
    }else{
        $('#form_servant').slideUp();
    }
});
JS;

$js[] = <<< JS
$('#person-type input:radio[checked]').trigger('change');
JS;
    
$this->registerJs(implode("\n", $js));