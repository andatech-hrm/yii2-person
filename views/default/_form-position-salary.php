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

use yii\helpers\Url;

use andahrm\edoc\models\Edoc;
use andahrm\edoc\models\EdocSearch;

$modelBase = new Position(['scenario'=>'search']);
?>
<?php
$section_json = Json::encode(Section::getList());
// $formatJs = <<< JS

// var section = $section_json;
// function formatRepo (state) {
//   if (!state.id) { return state.text; }
//   var \$state = $(
//     '<span>' + state.text + '</span>'
//   );
//   return \$state;
// };
// JS;
 
// // Register the formatting script
// $this->registerJs($formatJs, $this::POS_HEAD);
?>

 <?php /*<div class="row">
        
      <div class="col-sm-3">
        <?= $form->field($modelBase, 'section_id')->dropDownList(Section::getList(),[
        'prompt'=>Yii::t('app','Select'),
        'id'=>'ddl-section'
        ]) ?>
      </div>
      
      <div class="col-sm-3">
        <?= $form->field($modelBase, 'person_type_id')->widget(DepDrop::classname(), [
          'options'=>['id'=>'ddl-person_type'],
            //'data'=> PositionLine::getListByPersonType($modelBase->person_type_id),
            'pluginOptions'=>[
                'depends'=>['ddl-section'],
                'placeholder'=>Yii::t('app','Select'),
                'url'=>Url::to(['/salary-calculation/default/get-person-type'])
            ]
        ]); ?>
      </div>
      

      <div class="col-sm-3">
        <?= $form->field($modelBase, 'position_line_id')->widget(DepDrop::classname(), [
            'options'=>['id'=>'ddl-position_line'],
            //'data'=> PositionLine::getListByPersonType($modelBase->person_type_id),
            'pluginOptions'=>[
                'depends'=>['ddl-section','ddl-person_type'],
                'placeholder'=>Yii::t('app','Select'),
                'url'=>Url::to(['/salary-calculation/default/get-position-line'])
            ]
        ]); ?>
      </div>
</div> */ ?>
      
    <div class="row">   
      <div class="col-sm-6">
        <?php /*<?= $form->field($model, 'position_id')->widget(DepDrop::classname(), [
            'options'=>['id'=>'ddl-position'],
            //'data'=>[],
            'pluginOptions'=>[
                'depends'=>['ddl-section','ddl-person_type','ddl-position_line'],
                'placeholder'=>Yii::t('app','Select'),
                'url'=>Url::to(['/salary-calculation/default/get-position'])
            ]
        ]); ?> */ ?>
        <?php $positionInputId = Html::getInputId($model, 'position_id'); ?>
        <?= $form->field($model, 'position_id', [
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
      
       <div class="col-sm-2">
           <?= $form->field($model, "level")->textInput() ?>
       </div>
      
       <div class="col-sm-4"> 
            <?= $form->field($model, "salary")->textInput()?>
       </div>
      
    </div>  
    
    
    <div class="row">
        
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