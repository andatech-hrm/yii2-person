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
        ['class' => '\kartik\grid\ActionColumn',
        'template' => "{update} {delete}",
        'buttons' => [
            'update' => function ($url, $model) use($modals, $positions, $modalOptions, $newModelEdoc) {

                // $form = ActiveForm::begin();
                // $key = $model->formName();
                // $mkey = $positions[$key]['key'];
                // $modals[$mkey] = Modal::begin([
                //     'header' => '<i class="fa fa-user-secret"></i> ' . $positions[$key]['label'],
                //     'size' => Modal::SIZE_LARGE,
                //     'headerOptions' => $modalOptions['header-options'],
                //     'footer' => '<div class="pull-left aero"><i>' . Yii::t('andahrm', 'Last Update') . ': ' . 
                //         Yii::$app->formatter->asDateTime($model->updated_at) . '</i></div>' . 
                //         $modalOptions['form-buttons'],
                // ]);
                // echo $model->formName();
                // if($key == "PersonPositionSalaryOld"){
                //     echo $this->render('_form/_update_position-old', ['model' => $model, 'form' => $form,'newModelEdoc'=>$newModelEdoc]);
                // }else{
                //     echo $this->render('_form/_update_position-old', ['model' => $model, 'form' => $form,'newModelEdoc'=>$newModelEdoc]);
                // }
                // Modal::end();
                // ActiveForm::end();
                $old = false;
                $action = '';
                //return $model->formName().'=='.PersonPositionSalaryOld::getClassName();
                if ($model->formName() == 'PersonPositionSalaryOld') {
                    $positionId = $model->position_old_id;
                    $action = '/person/default/update-position-old';
                } else {
                    $positionId = $model->position_id;
                    $action = '/person/default/update-position';
                }

                return Html::a('<i class="fa fa-pencil"></i>', [
                            $action,
                            'id' => $model->user_id,
                            'position_id' => $positionId,
                            'edoc_id' => $model->edoc_id,
                                //'formAction'=>$action
                                ], [
                            //'class'=>'btn-update-old',
                            'data-pjax' => 0,
                                //'data-toggle' => 'modal',
                                //'data-target' => '#'.$modals['update-position']->id,
                                //'onclick' => "javascript::bindUpdatePosition({$model->user_id},{$positionId},{$model->edoc_id});",
                                //'title' => Yii::t('yii', 'Update')
                ]);
            },
            'delete' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('andahrm', 'Delete'),
                    'aria-label' => Yii::t('andahrm', 'Delete'),
                    'class' => 'btnDelete',
                    'data' => [
                        'confirm' => Yii::t('andahrm', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                    'data-pjax' => 0,
                ];

                if ($model->formName() == 'PersonPositionSalaryOld' && isset($model->position_old_id)) {
                    $url = Url::toRoute(['delete-position-old',
                                'user_id' => $model->user_id,
                                'position_id' => $model->position_old_id,
                                'edoc_id' => $model->edoc_id,
                    ]);
                } else {
                    $url = Url::toRoute(['delete-position',
                                'user_id' => $model->user_id,
                                'position_id' => $model->position_id,
                                'edoc_id' => $model->edoc_id
                    ]);
                }
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
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
    'export' => [
        'label' => Yii::t('andahrm', 'Page'),
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
        'before' => ' ' .
        Html::beginTag('div', ['class' => 'btn-group']) .
        Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('andahrm/person', 'Create Position New'), ['create-position', 'id' => $models['person']->user_id], [
            //'data-toggle'=>"modal",
            //'data-target'=>"#{$modals['position']->id}",
            'class' => 'btn btn-success btn-flat',
            'data-pjax' => 0
        ]) . ' ' .
        Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('andahrm/person', 'Create Position Old'), ['create-position-old', 'id' => $models['person']->user_id], [
            'class' => 'btn btn-warning btn-flat',
            'data-pjax' => 0
        ]) .
        Html::endTag('div'),
        'heading' => false,
    //'footer'=>false,
    ],
    'toolbar' => [
        '{export}',
        '{toggleData}',
        $fullExportMenu,
    ],
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


    