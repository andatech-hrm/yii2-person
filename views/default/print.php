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



<p class="text-center"><b>
    ๑๑. การได้รับโทษทางวินัย
</b></p>
<table class="table-print">
        <thead>
            <tr class="header-labels">
                <th class="text-center" style="width: 2cm;"><?= Yii::t('andahrm/position-salary', 'Adjust Date'); ?></th>
                <th class="text-center"><?= Yii::t('andahrm/position-salary', 'Title'); ?></th>
                <th class="text-center cell-right" style="width: 5cm;"><?= Yii::t('andahrm/position-salary', 'Edoc ID'); ?></th>
            </tr>
        </thead>
        <tbody>
           
            <?php foreach($dataDefect as $key => $model): ?>
                <tr>
                    <td><?= Yii::$app->formatter->asDate($model->date_defect); ?></td>
                    <td><?= $model->title; ?></td>
                    <td class="cell-right"><?= $model->edoc->title; ?></td>
                </tr>
            <?php endforeach; ?>
            <?php 
                for($i=0;$i<=($rowNum-count($dataDefect));$i++) : ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="cell-right"></td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>



<p class="text-center"><b>
    ๑๑. การได้รับโทษทางวินัย
</b></p>
<table class="table-print">
        <thead>
            <tr class="header-labels">
                <th class="text-center" style="width: 2cm;"><?= Yii::t('andahrm/position-salary', 'Adjust Date'); ?></th>
                <th class="text-center"><?= Yii::t('andahrm/position-salary', 'Title'); ?></th>
                <th class="text-center cell-right" style="width: 5cm;"><?= Yii::t('andahrm/position-salary', 'Edoc ID'); ?></th>
            </tr>
        </thead>
        <tbody>
           
            <?php foreach($dataDefect as $key => $model): ?>
                <tr>
                    <td><?= Yii::$app->formatter->asDate($model->date_defect); ?></td>
                    <td><?= $model->title; ?></td>
                    <td class="cell-right"><?= $model->edoc->title; ?></td>
                </tr>
            <?php endforeach; ?>
            <?php 
                for($i=0;$i<=($rowNum-count($dataDefect));$i++) : ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="cell-right"></td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>

