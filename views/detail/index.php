<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\person\models\DetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/person', 'Details');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$columns = [
    'user_id' => 'user_id',
    'nationality_id' => 'nationality_id',
    'race_id' => 'race_id',
    'religion_id' => 'religion_id',
    'blood_group' => 'blood_group',
    'address_contact_id' => 'address_contact_id',
    'address_birth_place_id' => 'address_birth_place_id',
    'address_register_id' => 'address_register_id',
    'mother_name' => 'mother_name',
    'father_name' => 'father_name',
    'married_status' => 'married_status',
    'people_spouse_id' => 'people_spouse_id',
];

$gridColumns = [
    $columns['nationality_id'],
    $columns['race_id'],
    $columns['religion_id'],
    $columns['blood_group'],
    $columns['address_contact_id'],
    //$columns['address_birth_place_id'],
    //$columns['address_register_id'],
    //$columns['mother_name'],
    //$columns['father_name'],
    $columns['married_status'],
    $columns['people_spouse_id'],
    ['class' => '\kartik\grid\ActionColumn',]
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

<div class="detail-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
