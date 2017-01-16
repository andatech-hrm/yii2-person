<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use andahrm\setting\models\Helper;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\person\models\ChildSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/person', 'Children').': '.$modelPerson->fullname;
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$columns = [
    'user_id' => 'user_id',
    'people_id' => 'people_id',
    'relation' => 'relation',
    'name' => 'people.name',
    'surname' => 'people.surname',
    'birthday' => 'people.birthday',
    'nationality' => 'people.nationality_id',
    'race' => 'people.race_id',
    'occupation' => 'people.occupation',
    'live_status' => 'people.live_status'
];

$gridColumns = [
    $columns['people_id'],
    $columns['relation'],
    $columns['name'],
    $columns['surname'],
    [
        'class' => '\kartik\grid\ActionColumn',
        'urlCreator' => function ($action, $model, $key, $index) {
            $params = Yii::$app->request->getQueryParams();
            unset($params['id'], $params['_pjax']);
            return Url::to(array_merge([$action], ['id' => $model->user_id, 'people_id' => $model->people_id, 'relation' => $model->relation], $params));
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
        'id' => 'child-grid',
        'pjax'=>true,
        'export' => [
//             'label' => Yii::t('yii', 'Page'),
            'fontAwesome' => true,
            'target' => GridView::TARGET_SELF,
            'showConfirmAlert' => false,
        ],
        'panel' => [
            'type' => 'info',
            'heading'=>'<h3 class="panel-title"><i class="fa fa-th"></i> '.$this->title.'</h3>',
            'before'=> '<div class="btn-group">'.
                Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('andahrm', 'Create'), Helper::urlParams('create'), [
                    'class' => 'btn btn-success btn-flat',
                    'data-pjax' => 0
                ]) . ' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('andahrm', 'Reload'), '', [
                    'class' => 'btn btn-info btn-flat btn-reload-child-grid',
                    'title' => 'Reload',
                    'id' => 'btn-reload-grid'
                ]) . ' '.
                '</div>',
            'after' => false,
            'footer' => false,
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
// $js[] = "
// $(document).on('click', '#btn-reload-child-grid', function(e){
//     e.preventDefault();
//     $.pjax.reload({container: '#child-grid-pjax'});
// });
// ";

// $this->registerJs(implode("\n", $js));
