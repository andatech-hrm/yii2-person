<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\person\models\PersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Persons');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$columns = [
    'user_id' => 'user_id',
    'citizen_id' => 'citizen_id',
    'title_id' => 'title_id',
    'fullname' => 'fullname',
    'contact' => [
        'attribute' => 'contact',
        'format' => 'html',
        'value' => function($model) {
            if ($model->addressContact === null) { return null; }
            $res = $model->getAddressText('contact', ['number' => true]);
            $res .= '<br />โทร. ';
            $res .= $model->addressContact->phone;
            return $res;
        },
    ],
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
    $columns['user_id'],
    $columns['citizen_id'],
    [
        'attribute' => 'fullname',
        'format' => 'html',
        'value' => function($model) {
            $res = '<div class="media"> <div class="media-left"> ' . 
                '<img class="media-object img-circle" src="'.$model->photoLast.'" style="width: 32px; height: 32px;"> </div> ' . 
                '<div class="media-body"> ' . 
                '<p class="media-heading">'.$model->fullname.'</p> ' . 
                '<small>'.$model->positionTitle.'<small></div> </div>';
            return $res;
        }
    ],
    $columns['contact'],
    [
        'class' => '\kartik\grid\ActionColumn',
//         'template' => '{update} {delete}',
//         'urlCreator' => function ($action, $model, $key, $index) {
//             $params = Yii::$app->request->getQueryParams();
//             unset($params['id'], $params['_pjax']);
//             return Url::to(array_merge(['default/'.$action], ['id' => $model->user_id], $params));
//         }
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
        'id' => 'data-grid',
        'tableOptions' => ['class' => 'jambo_table'],
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
            'heading'=>'<h3 class="panel-title"><i class="fa fa-th"></i> '.Html::encode($this->title).'</h3>',
//             'heading' => false,
//             'type'=>'primary',
            'before'=> '<div class="btn-group">'.
                Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('andahrm', 'Create'), ['create'], [
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
                ]) . ' '.
                '</div>',
            'after' => false,
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

$this->registerJs(implode("\n", $js));