<?php
use kartik\grid\GridView;
use kartik\export\ExportMenu;
?>
<div class="row">
    <div class="col-xs-6" style="display:table">
        <div style="display: table-cell; width:50px;"><?= $models['person']->getAttributeLabel('fullname'); ?></div>
        <div class="green" style="border-bottom: #ccc 1px dotted; display: table-cell; padding: 0 5px 0 15px;"><?= $models['person']->fullname; ?></div>
    </div>
    <div class="col-xs-2" style="display:table">
        <div style="display: table-cell; width:30px;"><?= $models['person']->positionSalary->getAttributeLabel('level'); ?></div>
        <div class="green" style="border-bottom: #ccc 1px dotted; display: table-cell; padding: 0 5px 0 15px;"><?= $models['person']->positionSalary->level; ?></div>
    </div>
</div>
<br>

<?php
$columns = [
    'created_at' => 'created_at:datetime',
    'created_by' => 'created_by',
    'updated_at' => 'updated_at',
    'updated_by' => 'updated_by',
    'status' => [
            'attribute'=>'status',
            'value' => 'statusLabel',
        ],
  'edoc_id' => [
        'attribute'=>'edoc_id',
        'format' => 'html',
        'value' => 'edoc.codeTitle',
    ],
  'user_id'=> [
        'attribute'=>'user_id',
        'format'=>'html',
        'value' => function($model){
            return $model->user->getInfoMedia(['view','edoc_id'=>$model->edoc_id]);
        },
        'contentOptions' => ['width' => '200']

    ],
  'fullname'=> [
        'attribute'=>'user_id',
        'value' => 'user.fullname'
    ],
  'position_id'=> [
        'attribute'=>'position_id',
        'format'=>'html',
        'value' => 'position.title'
    ],
  'adjust_date'=>[
      'attribute' => 'adjust_date',
      'format' => 'date',
      'label' => 'วัน เดือน ปี',
    ],
  'title'=>[
        'attribute'=>'title',
        'format'=>'html',
        'value' => 'titleStep',
        'label' => 'ตำแหน่ง',
    ],
    'code' => [
        'label' => 'เลขที่ตำแหน่ง',
        'value' => 'position.code'
    ],
  'salary'=>'salary:decimal',
  'step'=>'step',
  'level'=>'level',
];

$gridColumns = [
//   ['class' => '\kartik\grid\SerialColumn'],
    $columns['adjust_date'],
    //$columns['position_id'],  
    $columns['title'], 
    $columns['code'], 
    $columns['level'], 
    //$columns['status'],
    $columns['salary'],
    $columns['edoc_id']
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
<div class="person-kp">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'data-grid',
        'pjax'=>true,
        'export' => [
            // 'label' => Yii::t('yii', 'Page'),
            'fontAwesome' => true,
            'target' => GridView::TARGET_SELF,
            'showConfirmAlert' => false,
        ],
        'panel' => [
            'heading'=>false,
        ],
        // 'toolbar' => [
        //     '{export}',
        //     '{toggleData}',
        //     $fullExportMenu,
        // ],
        'columns' => $gridColumns,
    ]); ?>
</div>
