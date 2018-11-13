<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
####
use andahrm\insignia\models\InsigniaRequest;
use andahrm\insignia\models\InsigniaType;
use andahrm\structure\models\PersonType;
use andahrm\structure\models\FiscalYear;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\insignia\models\InsigniaRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="insignia-request-index">

    <?php
    $columns = [
        'year' => [
            'attribute' => 'yearly',
            'filter' => FiscalYear::getList(),
            'value' => function($model) {
                return $model->yearTh;
            }
        ],
        'insignia_type_id' => [
            'attribute' => 'insignia_type_id',
            'filter' => InsigniaType::getList(),
            'format' => 'html',
            'value' => 'insigniaType.titleIcon',
            'noWrap' => true,
        ],
//        'status' => [
//            'attribute' => 'insigniaRequest.status',
//            'filter' => InsigniaRequest::getItemStatus(),
//            'value' => function($model) {
//                return $model->insigniaRequest->statusLabel;
//            }
//        ],
        'edoc_id' => [
            'attribute' => 'edoc_insignia_id',
            'format' => 'html',
            'value' => function($model) {
                $edoc = $model->edoc_insignia_id ? $model->edocInsignia : null;
                //$insignia = $edoc->insignia?$edoc->insignia:null;
                return $edoc ? Html::a($edoc->title, ['/edoc/insignia/view', 'id' => $model->edoc_insignia_id], ['data-pjax' => 0]) : null;
                //return $edoc->insignia;
            }
        ]
    ];

    $gridColumns = [
            ['class' => '\kartik\grid\SerialColumn'],
        $columns['year'],
        //$columns['user_id'], 
        $columns['insignia_type_id'],
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
//        'export' => [
//            'label' => Yii::t('andahrm', 'Page'),
//            'fontAwesome' => true,
//            'target' => GridView::TARGET_SELF,
//            'showConfirmAlert' => false,
//        ],
//         'exportConfig' => [
//             GridView::HTML=>['filename' => $exportFilename],
//             GridView::CSV=>['filename' => $exportFilename],
//             GridView::TEXT=>['filename' => $exportFilename],
//             GridView::EXCEL=>['filename' => $exportFilename],
//             GridView::PDF=>['filename' => $exportFilename],
//             GridView::JSON=>['filename' => $exportFilename],
//         ],
//        'panel' => [
//            'before' => ' ' .
//            Html::beginTag('div', ['class' => 'btn-group']) .
//            Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('andahrm/insignia', 'Create Insignia Request'), ['create-insignia', 'id' => $user_id], [
//                'class' => 'btn btn-success btn-flat',
//                'data-pjax' => 0
//            ]) . ' ' .
//            Html::endTag('div'),
//            'heading' => false,
//        ],
//        'toolbar' => [
//            '{export}',
//            '{toggleData}',
//            $fullExportMenu,
//        ],
        'columns' => $gridColumns,
    ]);
    ?>

</div>