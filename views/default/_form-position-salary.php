<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;

// use kartik\grid\GridView;
// use kartik\export\ExportMenu;

use andahrm\edoc\models\Edoc;
use andahrm\person\models\Person;
use andahrm\structure\models\Position;
use andahrm\positionSalary\models\PersonPositionSalary;

use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\positionSalary\models\PersonPositionSalarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/position-salary', 'Person Position Salaries');
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="person-index">
    <h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
        <i class="<?= $this->context->formSteps[$step]['icon']; ?>"></i> Step <?=$step?>.1 
        <span class="text-muted"><?=Yii::t('andahrm/position-salary', 'Contracts')?></span>
         <?= Html::button('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('andahrm/person', 'Create Contract'), [
            'class' => 'pull-right btn btn-success btn-xs',
            'data-pjax' => 0,
            'data-toggle'=>"modal",
            'data-target'=>"#{$modals['contract']->id}"
        ]);?>
    </h2> 
    <?php $pjaxs['contract'] = Pjax::begin();?>
    <?php
    $columns = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute'=>'position_id',
            'value' => 'position.code'
        ],
        'start_date:date',
        'end_date:date',
        'work_date:date',
        [
            'attribute'=>'edoc_id',
            'format' => 'html',
            'value' => 'edoc.codeTitle',
        ],
        // 'created_at',
        // 'created_by',
        // 'updated_at',
        // 'updated_by',
        [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{delete}',
            'buttons'=>[
              'delete' => function ($url, $model, $key) use($step) {
                $options = [
                    'title' => Yii::t('andatech', 'Delete'),
                    'aria-label' => Yii::t('andatech', 'Delete'),
                    'class' => 'btnDelete',
                    //'data-pjax' => 1,
                ];
                if($model->formName() == "PersonContractOld"){
                    $url = Url::toRoute(['delete-contract',
                        'user_id' => $model->user_id,
                        'position_id' => $model->position_id,
                        'edoc_id' => $model->edoc_id,
                        'step'=>$step,
                        'old'=>true
                    ]);
                }else{
                    $url = Url::toRoute(['delete-contract',
                        'user_id' => $model->user_id,
                        'position_id' => $model->position_id,
                        'edoc_id' => $model->edoc_id,
                        'step'=>$step,
                    ]);
                }
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,$options);
                }
              ]
        
        ],
        ];
    echo  GridView::widget([
        'dataProvider' => $dataProviderContract,
        'columns' => $columns,
    ]); ?>
    <?php Pjax::end();?>
    
    <!--############################################################################-->
    <!--############################################################################-->
    <h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
        <i class="<?= $this->context->formSteps[$step]['icon']; ?>"></i> Step <?=$step?>.2
        <span class="text-muted"><?= $this->context->formSteps[$step]['desc']; ?></span>
        
        <?= Html::button('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('andahrm/person', 'Create Position Old'), [
                    'class' => 'pull-right btn btn-success btn-xs',
                    'data-pjax' => 0,
                    'data-toggle'=>"modal",
                    'data-target'=>"#{$modals['position-old']->id}"
                ])  ?>
        <?= Html::button('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('andahrm/person', 'Create Position New'), [
                    'class' => 'pull-right btn btn-success btn-xs',
                    'data-pjax' => 0,
                    'data-toggle'=>"modal",
                    'data-target'=>"#{$modals['position']->id}"
                ]);?>
                
    
   
    </h2> 
    
    
    <?php $pjaxs['positionOld'] = Pjax::begin();?>
    <?php
    $columns = [
      ['class' => 'yii\grid\SerialColumn'],
      'adjust_date'=>'adjust_date:date',
      'title',
        [
            'attribute'=>'position_id',
            'value' => 'position.code'
        ],
        'level',
        'salary:decimal',
       [
            'attribute'=>'edoc_id',
            'format' => 'html',
            'value' => 'edoc.codeTitle',
        ],
       ['class' => 'yii\grid\ActionColumn',
       'template'=>'{delete}',
       'buttons'=>[
          'delete' => function ($url, $model, $key) use($step) {
            $options = [
                'title' => Yii::t('andatech', 'Delete'),
                'aria-label' => Yii::t('andatech', 'Delete'),
                'class' => 'btnDelete',
                //'data-pjax' => 1,
            ];
            
            if(isset($model->position_old_id)){
                $url = Url::toRoute(['delete-position-old',
                    'user_id' => $model->user_id,
                    'position_id' => $model->position_id,
                    'edoc_id' => $model->edoc_id,
                    'step'=>$step,
                ]);
            }else{
                $url = Url::toRoute(['delete-position',
                    'user_id' => $model->user_id,
                    'position_id' => $model->position_id,
                    'edoc_id' => $model->edoc_id,
                    'step'=>$step,
                ]);
            }
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,$options);
            }
           ]
       ],
    ];
    echo  GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
    ]); ?>
    <?php Pjax::end();?>
    
    
    
    
    
</div>
<?php
$js[] = "
$(document).on('click', '#btn-reload-grid', function(e){
    e.preventDefault();
    $.pjax.reload({container: '#data-grid-pjax'});
});
";
$urlCreatePosition = Url::to(['/person/default/create-position'],true); 
/*
$js[] = <<< Js
var urlCreate = "{$urlCreatePosition}";
$(document).ready(function() {
    // $("#{$modals['position']->id}").modal('show');
    $('#{$modals['position']->id}').on('shown.bs.modal', function() {
        
        // var body = $(this).find('.modal-body');
        // $.get(urlCreate,function(data){
        //     $(body).html(data);
        // });
    });
});

Js;
*/
//$this->registerJs(implode("\n", $js));


// $this->registerJs("
// function initSelect2Loading(a,b){ initS2Loading(a,b); }
// function initSelect2DropStyle(id, kvClose, ev){ initS2Open(id, kvClose, ev); }", 
// $this::POS_HEAD);

$js[] = <<< JS

$('.btnDelete').click(function(){
    //$.pjax.reload({container:"#{$pjaxs['positionOld']->id}"});
});

function callbackPosition(result){
    //alert(result);
    $.pjax.reload({container:"#{$pjaxs['positionOld']->id}"});
     $("#{$modals['position-old']->id}").modal('hide');
     $("#{$modals['position']->id}").modal('hide');
}
function callbackContract(result){
    //alert(result);
    $.pjax.reload({container:"#{$pjaxs['contract']->id}"});
     $("#{$modals['contract']->id}").modal('hide');
}
JS;
    
$this->registerJs(implode("\n", $js));

