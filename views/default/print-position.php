<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

use kartik\grid\GridView;

use andahrm\edoc\models\Edoc;
use andahrm\person\models\Person;
use andahrm\structure\models\Position;
use andahrm\positionSalary\models\PersonPositionSalary;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\positionSalary\models\PersonPositionSalarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/position-salary', 'Person Position Salaries');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php

$columns = [
    'created_at' => 'created_at:datetime',
    'created_by' => 'created_by',
    'updated_at' => 'updated_at',
    'updated_by' => 'updated_by',
    'status' => [
        'attribute'=>'status',
        'filter' => PersonPositionSalary::getItemStatus(),
        'value' => 'statusLabel',
        //'group'=>true,
    ],
    'edoc_id' => [
        'attribute'=>'edoc_id',
        'filter' => Edoc::getList(),
        'format' => 'html',
        'value' => 'edoc.codeTitle',
        //'group'=>true,
    ],
    'user_id'=> [
        'attribute'=>'user_id',
        'filter' => Person::getList(),
        'format'=>'html',
        'value' => function($model){
            return $model->user->getInfoMedia(['view','edoc_id'=>$model->edoc_id]);
        },
        'contentOptions' => ['width' => '200']

    ],
    'fullname'=> [
        'attribute'=>'user_id',
        'filter' => Person::getList(),
        'value' => 'user.fullname'
    ],
    'position_id'=> [
        'attribute'=>'position_id',
        'filter' => Position::getList(),
        'value' => 'position.code'
    ],
    'adjust_date'=>'adjust_date:date',
    'title'=>'title',
    'salary'=>'salary:decimal',
    'step'=>'step',
    'level'=>'level',
];

$gridColumns = [
    // ['class' => '\kartik\grid\SerialColumn'],
    $columns['adjust_date'],
    //$columns['user_id'], 
    $columns['title'],
    $columns['position_id'],   
    //$columns['status'],
    $columns['level'],
    $columns['salary'],
    $columns['edoc_id'],   
];
?>

<div class="person-index">
    <table class="table-print">
        <thead>
            <tr>
                <th colspan="6" style="text-align: center; border:0;">
                    <h4><?= $this->title; ?></h4>
                </th>
            </tr>
            <tr>
                <th colspan="6" style="border:0">
                    <span>Name</span><span><?= $modelPerson->fullname; ?></span>
                    <span>Level</span><span><?= $modelPerson->position->positionLevel->title; ?></span>
                </th>
            </tr>
            <tr class="header-labels">
                <th class="text-center" style="width: 2cm;"><?= Yii::t('andahrm/position-salary', 'Adjust Date'); ?></th>
                <th class="text-center"><?= Yii::t('andahrm/position-salary', 'Title'); ?></th>
                <th class="text-center" style="width: 2cm;"><?= Yii::t('andahrm/position-salary', 'Position ID'); ?></th>
                <th class="text-center" style="width: 1cm;"><?= Yii::t('andahrm/position-salary', 'Level'); ?></th>
                <th class="text-center" style="width: 1.5cm;"><?= Yii::t('andahrm/position-salary', 'Salary'); ?></th>
                <th class="text-center cell-right" style="width: 5cm;"><?= Yii::t('andahrm/position-salary', 'Edoc ID'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($dataProvider->getModels() as $key => $model) : ?>
            <tr>
                <td><?= Yii::$app->formatter->asDate($model->adjust_date); ?></td>
                <td><?= $model->title; ?></td>
                <td class="text-center"><?php print_r($model->position->code); ?></td>
                <td class="text-center"><?= $model->level; ?></td>
                <td class="text-right"><?= $model->salary; ?></td>
                <td class="cell-right"><?= $model->edoc->codeTitle; ?></td>
            </tr>
            <?php endforeach; ?>
            <?php for($i=0;$i<50;$i++) : ?>
            <tr>
                <td><?= Yii::$app->formatter->asDate($model->adjust_date); ?></td>
                <td>Test row for many pages <?= $i; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cell-right"></td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>
    <br />
    <?php /*echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'id' => 'data-grid',
        'columns' => $gridColumns,
        'summary' => false,
    ]);*/ ?>
</div>
