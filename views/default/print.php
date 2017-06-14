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

//echo $f->format(1432);
?>



<p class="text-center" ><b>
    <!--๑๑. การได้รับโทษทางวินัย-->
    <?=Yii::t('andahrm/person','11. Punishment')?>
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
                for($i=0;$i<=($rowNum[0]-count($dataDefect));$i++) : ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="cell-right"></td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>



<p class="text-center" style="padding-top:10px;"><b>
    <!--๑๒. วันที่ไม่ได้รับเงินเดือนหรือได้รับเงินเดือนไม่เติม หรือวันที่มิได้ประจำปฎิบัติหน้าที่อยู่ในเขตที่ได้มีประกาศใช้กฎอัยการศึก-->
    <?=Yii::t('andahrm/person','12. Do not get a salary or get a salary')?>
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
                for($i=0;$i<=($rowNum[1]-count($dataDefect));$i++) : ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="cell-right"></td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
    
    
    
    
<!--33333333333333333333333333-->
    <br />
    
    
    
<table>
    <tr>
        <td width="350" style="vertical-align: top; padding-bottom:10px;">
            <!-- กระทรวง -->
            <?=Yii::t('andahrm/person','ministry')?>
            <span class="text-underdot">
                
            </span>
        </td>
        <td width="350" style="vertical-align: top; padding-bottom:10px;">
            <!-- กรม -->
            <?=Yii::t('andahrm/person','department')?>
             <span class="text-underdot">
                
            </span>
        </td>
        <td style="vertical-align: top; padding-bottom:10px;">
            <?=Yii::t('andahrm/person','kopo7')?>
        </td>
    </tr>
</table>

<table class="table-print">
       <tr class="body-labels-first">
            <th class="" >
                ๑. <?=Yii::t('andahrm/person', 'Name')?>
                <span class="text-underdot">
                    <?=$modelPerson->fullname ?>
                </span>
            </th>
            <th class="" style="width: 5cm;">
                ๔. <?=Yii::t('andahrm/person', 'Name').Yii::t('andahrm/person', 'Spouse'); ?>
                <span class="text-underdot">
                    <?=$modelPerson->peopleSpouse->fullname ?>
                </span>
            </th>
            <th class=" cell-right" style="width: 5cm;">
                ๗. <?=$modelPerson->getAttributeLabel('personContract.start_date'); ?>
                <span class="text-underdot">
                    <?=$modelPerson->personContract?Yii::$app->formatter->asDate($modelPerson->personContract->start_date):null ?>
                </span>
            </th>
        </tr>
        
        <tr class="body-labels">
            <th class="" >
                ๒. <?=$modelPerson->getAttributeLabel('birthday'); ?>
                <span class="text-underdot">
                    <?=$modelPerson->birthday?Yii::$app->formatter->asDate($modelPerson->birthday,'long'):null; ?>
                </span>
                <p style="line-height: 0.8">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                ( <span class="text-underdot" >
                     <?=$dates['birthday']; ?> 
                </span> )
                </p>
            </th>
            <th class="">
                ๕. <?=Yii::t('andahrm/person', 'Name').Yii::t('andahrm/person', 'Father'); ?>
                <span class="text-underdot">
                    <?=$modelPerson->peopleFather->fullname ?>
                </span>
            </th>
            <th class="cell-right" style="width: 5cm;">
               ๘. <?=$modelPerson->getAttributeLabel('personContract.work_date'); ?>
                <span class="text-underdot">
                    <?=$modelPerson->personContract?Yii::$app->formatter->asDate($modelPerson->personContract->work_date):null ?>
                </span>
            </th>
        </tr>
        
        <tr class="body-labels">
            <th class="" >
                ๓. <?=$modelPerson->getAttributeLabel('personContract.end_date'); ?>
                <span class="text-underdot">
                    <?=$modelPerson->personContract?Yii::$app->formatter->asDate($modelPerson->personContract->end_date):null ?>
                </span>
            </th>
            <th class="">
                ๖. <?=Yii::t('andahrm/person', 'Name').Yii::t('andahrm/person', 'Mother'); ?>
                <span class="text-underdot">
                    <?=$modelPerson->peopleMother->fullname ?>
                </span>
            </th>
            <th class="cell-right" >
               ๙. <?=Yii::t('andahrm/structure', 'Goverment Type'); ?>
                <span class="text-underdot">
                    <?=$modelPerson->positionSalary->position->personType->title ?>
                </span>
            </th>
        </tr>
</table>

<!--444444444444444444444-->

<p class="text-center" style="padding-top:10px;"><b>
    <!--๑๐. ประวัติการศึกษา ฝึกอบรมและดูงาน-->
    <?=Yii::t('andahrm/person','10. history of education Train and watch')?>
</b></p>



<table class="table-print">
        <thead>
            <tr class="header-labels">
                <th class="text-center" style="width: 4cm;"><?= Yii::t('andahrm/person', 'Education Train and watch'); ?></th>
                <th class="text-center"><?= Yii::t('andahrm/person', 'Start - End Date (Mounth Year)'); ?></th>
                <th class="text-center"><?= Yii::t('andahrm/person', 'Qualification Specify majors'); ?></th>
                <th class="text-center" style="width: 0.5cm;" > </th>
                <th class="text-center" style="width: 4cm;"><?= Yii::t('andahrm/person', 'Education Train and watch'); ?></th>
                <th class="text-center"><?= Yii::t('andahrm/person', 'Start - End Date (Mounth Year)'); ?></th>
                <th class="text-center cell-right" ><?= Yii::t('andahrm/person', 'Qualification Specify majors'); ?></th>
            </tr>
        </thead>
        <tbody>
           
            <?php foreach($dataDefect as $key => $model): ?>
                <tr>
                    <td><?= Yii::$app->formatter->asDate($model->date_defect); ?></td>
                    <td><?= $model->title; ?></td>
                    <td><?= Yii::$app->formatter->asDate($model->date_defect); ?></td>
                    <td></td>
                    <td><?= Yii::$app->formatter->asDate($model->date_defect); ?></td>
                    <td><?= $model->title; ?></td>
                    <td class="cell-right"><?= $model->edoc->title; ?></td>
                </tr>
            <?php endforeach; ?>
            <?php 
                for($i=0;$i<=($rowNum[2]-count($dataDefect));$i++) : ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cell-right"></td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
    
    
    
    
    
    <!--55555555555555555555555-->
    <br/>
    <table >
        <tbody>
            <tr >
                <td class="text-center" width="350" style="vertical-align: top;">
                    <p>
                        <!--ลงชื่อ-->
                        (<?= Yii::t('andahrm', 'sign');?>)
                        ..............................................................................................
                    </p>
                    <p>
                        <!--เจ้าของประวัติ-->
                        (<?= Yii::t('andahrm/person', 'History owner');?>)
                    </p>
                    <p>....................../...................../.....................</p>
                </td>
                
                <td class="text-center" style="vertical-align: top;padding-left:30px;">
                    <p>
                        <!--ลงชื่อ-->
                        (<?= Yii::t('andahrm', 'sign');?>)อ)
                        ..............................................................................................
                    </p>
                    <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        (..............................................................................................)
                    </p>
                    <p>
                        <!--ตำแหน่ง-->
                        <?= Yii::t('andahrm/position-salary', 'Position');?>
                        ............................................................................................
                    </p>
                    <p>
                        <!--หัวหน้าส่วนราชการหรือผู้ที่หัวหน้าส่วนราชการมอบหมาย-->
                       <?= Yii::t('andahrm/person', 'Head of government agency');?>
                    </p>
                    <p>....................../...................../.....................</p>
                </td>
            </tr>
        </tbody>
    </table>