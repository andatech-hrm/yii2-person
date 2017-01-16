<?php
use yii\bootstrap\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use andahrm\person\models\Helper;
?>
<?php
echo Yii::$app->formatter->dateFormat;
$columns = [
    'user_id' => 'user_id',
    'citizen_id' => 'citizen_id',
    'title_id' => 'title_id',
    'fullname' => 'fullname',
    'gender' => 'gender',
    'tel' => 'tel',
    'phone' => 'phone',
    'birthday' => 'birthday',
    'created_at' => 'created_at',
    'created_by' => 'created_by',
    'updated_at' => 'updated_at',
    'updated_by' => 'updated_by',
];

$gridColumns = [
//     $columns['fullname'],
    [
        'attribute' => 'fullname',
        'header' => Yii::t('andahrm/person', 'Fullname'),
        'filterInputOptions' => [
            'placeholder' => 'Search',
            'class' => 'form-control'
        ]
    ],
    [
        'class' => '\kartik\grid\ActionColumn',
        'template' => '{update} {delete}',
        'urlCreator' => function ($action, $model, $key, $index) {
            $params = Yii::$app->request->getQueryParams();
            unset($params['id'], $params['_pjax']);
            return Url::to(array_merge(['default/'.$action], ['id' => $model->user_id], $params));
        }
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
        'filterModel' => $searchModel,
        'hover' => true,
        'rowOptions'=>function($model){
            if($model->user_id == Yii::$app->request->get('id')){
                return ['class' => 'success', 'style' => 'font-weight:bold;'];
            }
        },
        'id' => 'data-grid',
        'pjax'=>true,
        'export' => [
//             'label' => Yii::t('yii', 'Page'),
            'fontAwesome' => true,
            'target' => GridView::TARGET_SELF,
            'showConfirmAlert' => false,
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="fa fa-th"></i> Person</h3>',
            'before'=> '',
            'after' => false,
            'footer' => '{export} {toggleData} '.$fullExportMenu,
        ],
        'toolbar' => '<div class="btn-group">'.
            Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('andahrm', 'Create'), ['default/create'], [
                'class' => 'btn btn-success btn-flat',
                'data-pjax' => 0
            ]) . ' '.
            Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('andahrm', 'Reload'), '', [
                'class' => 'btn btn-info btn-flat btn-reload',
                'title' => 'Reload',
                'id' => 'btn-reload-grid'
            ]) . ' '.
            Html::a('<i class="glyphicon glyphicon-trash"></i> '.Yii::t('andahrm', 'Trash'), ['trash/index'], [
                'class' => 'btn btn-warning btn-flat',
                'data-pjax' => 0
            ]) . ' '.'</div>',
        'columns' => $gridColumns,
    ]); ?>
</div>
<?php
// $js[] = "
// $(document).on('click', '#btn-reload-grid', function(e){
//     e.preventDefault();
//     $.pjax.reload({container: '#data-grid-pjax'});
// });
// ";

// $this->registerJs(implode("\n", $js));


