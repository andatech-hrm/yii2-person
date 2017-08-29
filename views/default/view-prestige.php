<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\Pjax;

use andahrm\insignia\models\InsigniaRequest;
use andahrm\insignia\models\InsigniaType;

use andahrm\structure\models\PersonType;
use andahrm\structure\models\FiscalYear;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\insignia\models\InsigniaRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/person', 'Prestige');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Person'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $models['person']->fullname, 'url' => ['view', 'id' => $models['person']->user_id]];
//$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insignia-request-index">
    
    <?php


$columns = [
    
                'year'=>[
                'attribute'=> 'insigniaRequest.year',
                'filter'=>FiscalYear::getList(),
                'value' => function($model){
                    return $model->insigniaRequest->yearTh;
                    }
                ],
                'insignia_type_id'=>[
                'attribute'=> 'insignia_type_id',
                'filter'=>InsigniaType::getList(),
                'format'=>'html',
                'value' => 'insigniaType.titleIcon'
                ],
                
                
                 'status'=>[
                'attribute'=> 'insigniaRequest.status',
                'filter'=>InsigniaRequest::getItemStatus(),
                'value' => function($model){
                    return $model->insigniaRequest->statusLabel;
                }
                
                ],
           
];

$gridColumns = [
    ['class' => '\kartik\grid\SerialColumn'],
    $columns['year'],
    //$columns['user_id'], 
    $columns['insignia_type_id'],
    $columns['status'],   
    ['class' => '\kartik\grid\ActionColumn']
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
            'before'=> ' '.
                Html::beginTag('div',['class'=>'btn-group']).
                    Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('andahrm/insignia', 'Create Insignia Request'), ['create-insignia','id'=>$user_id], [
                         //'data-toggle'=>"modal",
                         //'data-target'=>"#{$modals['position']->id}",
                        'class' => 'btn btn-success btn-flat',
                        'data-pjax' => 0
                    ]) . ' '. 
                   
                Html::endTag('div'),
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