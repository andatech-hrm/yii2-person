<?php
use yii\helpers\Html;
use andahrm\structure\models\Position;
use andahrm\setting\models\WidgetSettings;
use kartik\widgets\Select2;
use yii\widgets\Pjax;

use andahrm\structure\models\PersonType;
use andahrm\structure\models\BaseSalary;
use andahrm\structure\models\PositionLine;
use andahrm\structure\models\Section;
use kartik\widgets\DepDrop;
use yii\web\JsExpression;
use yii\helpers\Json;
use andahrm\datepicker\DatePicker;

use yii\helpers\Url;

use andahrm\edoc\models\Edoc;
use andahrm\edoc\models\EdocSearch;

$modelBase = new Position(['scenario'=>'search']);
?>
<?php
$section_json = Json::encode(Section::getList());
?>
      
    <div class="row">
        <?= $form->field($model, "title", ['options' => ['class' => 'form-group col-sm-6']])->textInput() ?>

        <?php $positionInputId = Html::getInputId($model, 'position_id'); ?>
        <?= $form->field($model, 'position_id', [
            'options' => ['class' => 'form-group col-sm-6'],
            'inputTemplate' => '{input}<div class="text-info" id="'.$positionInputId.'-prop" style="padding:3px;font-style: italic;"></div>'
            ])->widget(Select2::className(), WidgetSettings::Select2([
            'data' => Position::getListTitle(),
            'pluginOptions' => [
                'templateResult' => new JsExpression('formatPosition'),
            ],
            'pluginEvents' => [
                "select2:select" => "function(event) { 
                    var text = position_prop[event.target.value].type + ' / ' +
                    position_prop[event.target.value].section + ' / ' +
                    position_prop[event.target.value].positionLine
                    \$('#".$positionInputId."-prop').text(text);
                }",
            ]
        ]))
        ?>
    </div>
    
    <div class="row">
        <?= $form->field($model, "level", ['options' => ['class' => 'form-group col-sm-2']])->textInput() ?>
      
        <?= $form->field($model, "salary", ['options' => ['class' => 'form-group col-sm-2']])->textInput()?>
      
        <?= $form->field($model, "status", ['options' => ['class' => 'form-group col-sm-2']])->dropDownlist($model->getItemStatus())?>
        
        <?php
            $edocInputTemplate = <<< HTML
<div class="input-group">
    {input}
    <span class="input-group-btn">
        <button type="button" class="btn btn-success" role="edoc" data-toggle="modal" data-target="#{$modals['edoc']->id}"><i class="fa fa-plus"></i></button>
    </span>
</div>
HTML;
?>
            <?= $form->field($model, "edoc_id", [
                'inputTemplate' => $edocInputTemplate,
                'options' => [
                    'class' => 'form-group col-sm-6'
                ]
            ])->widget(Select2::className(), WidgetSettings::Select2(['data' => Edoc::getList()])) ?>
    </div>
    
    <h4 class="page-header" style="margin:15px 0 10px 0">สัญญาจ้าง</h4>
    <?= $form->field($modelContract, "start_date", ['options' => ['class' => 'form-group col-sm-6']])->widget(DatePicker::className(), WidgetSettings::DatePicker())?>
    
    <?= $form->field($modelContract, "end_date", ['options' => ['class' => 'form-group col-sm-6']])->widget(DatePicker::className(), WidgetSettings::DatePicker())?>

<?php
$edocInputId = Html::getInputId($model, 'edoc_id');
$jsHead[] = <<< JS
function callbackEdoc(result)
{   
    $("#{$edocInputId}").append($('<option>', {
        value: result.id,
        text: result.code + ' - ' + result.title
    }));
    $("#{$edocInputId}").val(result.id).trigger('change.select2');
    
    $("#{$modals['edoc']->id}").modal('hide');
}
JS;

$position_prop = Json::encode(Position::getListProp());
$jsHead[] = <<< JS
var position_prop = $position_prop;
function formatPosition (position) {
    if (!position.id) { return position.text; }
    var position = $(
        '<span>' + position.text + '<br/><i style="opacity: 0.5">' + position_prop[position.element.value].type + ' / ' +
        position_prop[position.element.value].section + ' / ' +
        position_prop[position.element.value].positionLine +
        '</i></span>'
    );
    return position;
};
JS;

$this->registerJs(implode("\n", $jsHead), $this::POS_HEAD);