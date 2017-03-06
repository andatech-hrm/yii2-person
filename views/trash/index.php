<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\person\models\PersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trash::'.Yii::t('andahrm/person', 'Person');
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
    'full_address_contact' => [
        'attribute' => 'full_address_contact',
        'format' => 'html',
        'value' => function($model) {
            // if ($model->addressContact === null) { return null; }
            $res = $model->full_address_contact;
            $res .= '<br />'.$model->addressContact->postcode.' &nbsp<i class="fa fa-phone"></i>โทร. ';
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
    // $columns['user_id'],
    $columns['citizen_id'],
    [
        'attribute' => 'fullname',
        'format' => 'raw',
        'value' => function($model) {
            $res = '<div class="media"> <div class="media-left"> ' . 
                '<img class="media-object img-circle" src="'.$model->photoLast.'" style="width: 32px; height: 32px;"> </div> ' . 
                '<div class="media-body"> ' . 
                '<h4 class="media-heading" style="margin:0;">' . 
                Html::a($model->fullname, ['view', 'id' => $model->user_id], ['class' => 'green', 'data-pjax' => 0]) . '</h4> ' . 
                '<small>'.$model->positionTitle.'<small></div> </div>';
            return $res;
        }
    ],
    $columns['full_address_contact'],
    [
        'class' => '\kartik\grid\ActionColumn',
         'template' => '{delete}',
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
        'export' => [
            'label' => Yii::t('yii', 'Page'),
            'fontAwesome' => true,
            'target' => GridView::TARGET_SELF,
            'showConfirmAlert' => false,
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="fa fa-th"></i> '.Html::encode($this->title).'</h3>',
            'type' => 'danger',
            'before'=> '<div class="btn-group">'.
                Html::a('<i class="glyphicon glyphicon-th-list"></i> '.Yii::t('andahrm/person', 'Person'), ['default/index'], [
                    'class' => 'btn btn-primary btn-flat',
                    'data-pjax' => 0
                ]) . ' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('andahrm', 'Reload'), '', [
                    'class' => 'btn btn-info btn-flat btn-reload',
                    'title' => 'Reload',
                    'id' => 'btn-reload-grid'
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