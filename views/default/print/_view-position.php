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