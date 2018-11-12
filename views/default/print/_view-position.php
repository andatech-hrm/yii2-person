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
use andahrm\positionSalary\models\PersonPositionSalaryOld;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\positionSalary\models\PersonPositionSalarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/person', 'Position');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Person'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $models['person']->fullname, 'url' => ['view', 'id' => $models['person']->user_id]];
//$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
$this->params['breadcrumbs'][] = $this->title;

$modals['update-position'] = Modal::begin([
            'header' => Yii::t('andahrm/person', 'Position'),
            'size' => Modal::SIZE_LARGE
        ]);
Modal::end();

$modalOptions = [
    'form-buttons' => Html::resetButton('<i class="fa fa-recycle"></i> ' . Yii::t('andahrm', 'Reset'), ['class' => 'btn btn-default']) . Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('andahrm', 'Save'), ['class' => 'btn btn-primary btn-modal-save']),
    'header-options' => [
        'class' => 'bg-primary',
        'style' => 'border-top-left-radius:5px; border-top-right-radius:5px;'
    ]
];

$positions = [
    'PersonPositionSalary' => ['key' => 'position', 'label' => Yii::t('andahrm/person', 'Position New')],
    'PersonPositionSalaryOld' => ['key' => 'position-old', 'label' => Yii::t('andahrm/person', 'Position Old')],
];
?>

<?php
$columns = [
    'adjust_date' => [
        'attribute' => 'adjust_date',
        'contentOptions' => ['class' => 'green'],
        'format' => 'date'
    ],
    'title' => [
        'attribute' => 'title',
        'format' => 'html',
        'value' => function($model) {
            return $model->getTitle();
        },
        'contentOptions' => ['class' => 'green'],
    ],
    'step' => [
        'attribute' => 'step',
        'contentOptions' => ['class' => 'green'],
    ],
    'level' => [
        'attribute' => 'level',
        'contentOptions' => ['class' => 'green'],
    ],
    'position_id' => [
        'attribute' => 'position_id',
        //'filter' => Position::getList(),
        'value' => 'position.code',
        'content' => function($model) {
            if ($model->formName() == 'PersonPositionSalaryOld') {
                $action = '/structure/position-old/view';
            } else {
                $action = '/structure/position/view';
            }
            return Html::a($model->position->code, [$action, 'id' => $model->position->id], ['target' => '_blank', 'data-pjax' => 0]);
        },
        'contentOptions' => ['class' => 'green'],
        'format' => 'html',
    ],
    'status' => [
        'attribute' => 'status',
        //'filter' => PersonPositionSalary::getItemStatus(),
        'value' => 'statusLabel',
        'contentOptions' => ['class' => 'green'],
    //'group'=>true,
    ],
    'salary' => [
        'attribute' => 'salary',
        'format' => 'decimal',
        'contentOptions' => ['class' => 'green text-right'],
    ],
    'edoc_id' => [
        'attribute' => 'edoc_id',
        //'filter' => Edoc::getList(),
        'format' => 'html',
        'content' => function($model) {
            return $model->edoc->codeDateTitleFileLink;
        },
        'contentOptions' => ['class' => 'green'],
    //'group'=>true,
    ],
    'user_id' => [
        'attribute' => 'user_id',
        //'filter' => Person::getList(),
        'format' => 'html',
        'value' => function($model) {
            return $model->user->getInfoMedia(['view', 'edoc_id' => $model->edoc_id]);
        },
        'contentOptions' => ['width' => '200', 'class' => 'green']
    ],
    'fullname' => [
        'attribute' => 'user_id',
        //'filter' => Person::getList(),
        'value' => 'user.fullname',
        'contentOptions' => ['class' => 'green'],
    ],
    'created_at' => 'created_at:datetime',
    'created_by' => 'created_by',
    'updated_at' => 'updated_at',
    'updated_by' => 'updated_by',
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
                'label' => Yii::t('andahrm', 'Full'),
                'class' => 'btn btn-default',
                'itemsBefore' => [
                    '<li class="dropdown-header">Export All Data</li>',
                ],
            ],
        ]);
?>
<div class="person-index">

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'id' => 'data-grid',
    'pjax' => true,
//        'resizableColumns'=>true,
//        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
//        'floatHeader'=>true,
//        'floatHeaderOptions'=>['scrollingTop'=>'50'],
//    'export' => [
//        'label' => Yii::t('andahrm', 'Page'),
//        'fontAwesome' => true,
//        'target' => GridView::TARGET_SELF,
//        'showConfirmAlert' => false,
//    ],
//         'exportConfig' => [
//             GridView::HTML=>['filename' => $exportFilename],
//             GridView::CSV=>['filename' => $exportFilename],
//             GridView::TEXT=>['filename' => $exportFilename],
//             GridView::EXCEL=>['filename' => $exportFilename],
//             GridView::PDF=>['filename' => $exportFilename],
//             GridView::JSON=>['filename' => $exportFilename],
//         ],
//    'panel' => [
//        'before' => ' ' .
//        Html::beginTag('div', ['class' => 'btn-group']) .
//        Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('andahrm/person', 'Create Position New'), ['create-position', 'id' => $models['person']->user_id], [
//       
//            'class' => 'btn btn-success btn-flat',
//            'data-pjax' => 0
//        ]) . ' ' .
//        Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('andahrm/person', 'Create Position Old'), ['create-position-old', 'id' => $models['person']->user_id], [
//            'class' => 'btn btn-warning btn-flat',
//            'data-pjax' => 0
//        ]) .
//        Html::endTag('div'),
//        'heading' => false,
//    ],
//    'toolbar' => [
//        '{export}',
//        '{toggleData}',
//        //$fullExportMenu,
//    ],
    'columns' => $gridColumns,
]);
?>
</div>
    <?php
    $js[] = "
$(document).on('click', '#btn-reload-grid', function(e){
    e.preventDefault();
    $.pjax.reload({container: '#data-grid-pjax'});
});
";
    $urlCreatePosition = Url::to(['/person/default/create-position'], true);
    $modalId = $modals['update-position']->id;
    $js[] = <<< Js
    // $('.data-grid-container .btn-update-old').each(function(){
    //   $(this).bind('click', function() {
    //         aler($(this).attr('href'));
    //     }); 
    // });
    // $(document).ready(function() {
    // function bindUpdatePosition( id, position_id, edoc_id)
    // {
    //     alert(id+" "+position_id+" "+edoc_id);
    // }
    // });
    
    $(document).ready(function() {
       $(document).on('click', '.btn-update-old', function(){
           //console.log($(this).attr('href'));
            // $("#{$modalId} .madal-body").load($(this).attr('href'));
            $.get($(this).attr('href'),
            function (data) {
                //alert(data);
                $("#{$modalId}").find('.modal-body').html(data);
                //$("#{$modalId} .modal-content .madal-body").html(data);
                //$("#{$modalId}").modal();
            });
        });
    });
    
    
    
    
Js;
    $js[] = <<< Js
    function callbackPosition(result){
    //e.preventDefault();
    //alert(555);
        $.pjax.reload({container: '#data-grid-pjax'});
        $("#{$modalId}").modal('hide');
        $('#{$modalId}').on('hidden.bs.modal', function (e) {
            $(this).find('.modal-body').html('');
        })
    }
Js;
    $this->registerJs(implode("\n", $js), $this::POS_END);


    