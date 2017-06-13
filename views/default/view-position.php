<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

use kartik\grid\GridView;
use kartik\export\ExportMenu;

use andahrm\edoc\models\Edoc;
use andahrm\person\models\Person;
use andahrm\structure\models\Position;
use andahrm\positionSalary\models\PersonPositionSalary;

use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\positionSalary\models\PersonPositionSalarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/person', 'Position');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Person'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $models['person']->fullname, 'url' => ['view', 'id' => $models['person']->user_id]];
//$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
$this->params['breadcrumbs'][] = $this->title;

// $modals['position'] = Modal::begin([
//     'header' => Yii::t('andahrm/person', 'Position'),
//     'size' => Modal::SIZE_LARGE
// ]);

// echo Yii::$app->runAction('/person/default/create-position-old', [
//     'formAction' => Url::to(['/edoc/default/create-position-old'])
//     ]);

// Modal::end();
?>

<?php
$columns = [
    'created_at' => 'created_at:datetime',
    'created_by' => 'created_by',
    'updated_at' => 'updated_at',
    'updated_by' => 'updated_by',
  'edoc_id' => [
        'attribute'=>'edoc_id',
        'filter' => Edoc::getList(),
        'value' => 'edoc.code',
  //'group'=>true,
    ],
  'user_id'=> [
        'attribute'=>'user_id',
        'filter' => Person::getList(),
        'value' => 'user.fullname'
    ],
  'position_id'=> [
        'attribute'=>'position_id',
        'filter' => Position::getList(),
        'value' => 'position.code'
    ],
  'adjust_date'=>'adjust_date:date',
  'title'=>'title',
];

$gridColumns = [
   ['class' => '\kartik\grid\SerialColumn'],
    //$columns['user_id'],
  
    $columns['adjust_date'],
    $columns['title'],
    $columns['position_id'],   
    $columns['edoc_id'], 
   
];

$columns = [
    'created_at' => 'created_at:datetime',
    'created_by' => 'created_by',
    'updated_at' => 'updated_at',
    'updated_by' => 'updated_by',
    'status' => [
            'attribute'=>'status',
            'filter' => PersonPositionSalary::getItemStatus(),
            'value' => 'statusLabel',
      //'group'=>true,
        ],
  'edoc_id' => [
        'attribute'=>'edoc_id',
        'filter' => Edoc::getList(),
        'format' => 'html',
        'value' => 'edoc.codeDateTitleFile',
  //'group'=>true,
    ],
  'user_id'=> [
        'attribute'=>'user_id',
        'filter' => Person::getList(),
        'format'=>'html',
        'value' => function($model){
            return $model->user->getInfoMedia(['view','edoc_id'=>$model->edoc_id]);
        },
        'contentOptions' => ['width' => '200']

    ],
  'fullname'=> [
        'attribute'=>'user_id',
        'filter' => Person::getList(),
        'value' => 'user.fullname'
    ],
  'position_id'=> [
        'attribute'=>'position_id',
        'filter' => Position::getList(),
        'value' => 'position.code'
    ],
  'adjust_date'=>'adjust_date:date',
  'title'=>'title',
  'salary'=>'salary:decimal',
  'step'=>'step',
  'level'=>'level',
];

$gridColumns = [
   ['class' => '\kartik\grid\SerialColumn'],
   $columns['adjust_date'],
    //$columns['user_id'], 
    $columns['title'],
    $columns['position_id'],   
    //$columns['status'],
    $columns['level'],
    $columns['salary'],
    $columns['edoc_id'],
    ['class' => '\kartik\grid\ActionColumn',
    'template'=>"{delete}",
    'buttons'=>[
        'delete' => function ($url, $model, $key) {
            $options = [
                'title' => Yii::t('andatech', 'Delete'),
                'aria-label' => Yii::t('andatech', 'Delete'),
                'class' => 'btnDelete',
                //'data-pjax' => 1,
            ];
            
            if($model->formName() == 'PersonPositionSalaryOld' && isset($model->position_old_id)){
                $url = Url::toRoute(['delete-position-old',
                    'user_id' => $model->user_id,
                    'position_id' => $model->position_old_id,
                    'edoc_id' => $model->edoc_id,
                ]);
            }else{
                $url = Url::toRoute(['delete-position',
                    'user_id' => $model->user_id,
                    'position_id' => $model->position_id,
                    'edoc_id' => $model->edoc_id
                ]);
            }
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,$options);
            }
        ]
    
    ]
];

$fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
    'filename' => $this->title,
    'showConfirmAlert' => false,
    'target' => ExportMenu::TARGET_BLANK,
    'fontAwesome' => true,
    'pjaxContainerId' => 'kv-pjax-container',
    'dropdownOptions' => [
        'label' => 'Full',
        'class' => 'btn btn-default',
        'itemsBefore' => [
            '<li class="dropdown-header">Export All Data</li>',
        ],
    ],
]);
?>
<div class="person-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'id' => 'data-grid',
        'pjax'=>true,
//        'resizableColumns'=>true,
//        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
//        'floatHeader'=>true,
//        'floatHeaderOptions'=>['scrollingTop'=>'50'],
        'export' => [
            'label' => Yii::t('yii', 'Page'),
            'fontAwesome' => true,
            'target' => GridView::TARGET_SELF,
            'showConfirmAlert' => false,
        ],
//         'exportConfig' => [
//             GridView::HTML=>['filename' => $exportFilename],
//             GridView::CSV=>['filename' => $exportFilename],
//             GridView::TEXT=>['filename' => $exportFilename],
//             GridView::EXCEL=>['filename' => $exportFilename],
//             GridView::PDF=>['filename' => $exportFilename],
//             GridView::JSON=>['filename' => $exportFilename],
//         ],
        'panel' => [
            //'heading'=>'<h3 class="panel-title"><i class="fa fa-th"></i> '.Html::encode($this->title).'</h3>',
//             'type'=>'primary',
            'before'=> ' '.
                Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('andahrm/person', 'Create Position New'), ['create-position','id'=>$user_id], [
                     //'data-toggle'=>"modal",
                     //'data-target'=>"#{$modals['position']->id}",
                    'class' => 'btn btn-success btn-flat',
                    'data-pjax' => 0
                ]) . ' '. 
                Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('andahrm/person', 'Create Position Old'), ['create-position-old','id'=>$user_id], [
                    'class' => 'btn btn-success btn-flat',
                    'data-pjax' => 0
                ]) . ' '.
                Html::a('<i class="glyphicon glyphicon-print"></i> '.Yii::t('andahrm/person', 'Print Position Histories'), ['print-position','id'=>$user_id], [
                    'class' => 'btn btn-default btn-flat',
                    'target' => '_blank',
                    'data-pjax' => 0
                ]) . ' '.
                ' ',
                'heading'=>false,
                //'footer'=>false,
        ],
        'toolbar' => [
            '{export}',
            '{toggleData}',
            $fullExportMenu,
        ],
        'columns' => $gridColumns,
    ]); ?>
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
$this->registerJs(implode("\n", $js));


