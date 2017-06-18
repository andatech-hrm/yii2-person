<?php

namespace andahrm\person\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use kartik\mpdf\Pdf;

use andahrm\person\models\User;
use andahrm\person\models\Person;

class PrintController extends \yii\web\Controller
{
    
     protected function findModel($id)
    {
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionIndex($id)
    {
        //$ss = \andahrm\person\assets\PrintAsset::register($this);
        
        $this->layout = 'view';
        
        $modelPerson =$this->findModel($id);
        
        $rowNum[0] = 8;
        $rowNum[1] = 9;
        $rowNum[2] = 9;
        $rowNum[3] = 80; #position
        $dataDefect = [];
        $modelDefect = $modelPerson->defects;
        for($i = 0;$i<=$rowNum[0];$i++ ){
             //$dataDefect[$i] = null;
            if(isset($modelDefect[$i])){
                $dataDefect[$i] = $modelDefect[$i];
            }
        }
        // echo "<pre>";
        // print_r($dataDefect);
        // exit();
        
        $f = new \NumberFormatter("th", \NumberFormatter::SPELLOUT);
        $dates['birthday'] = $f->format(Yii::$app->formatter->asDate($modelPerson->birthday,"php:d"))
                        ." ".Yii::$app->formatter->asDate($modelPerson->birthday,'php:F')
                        ." ".$f->format(Yii::$app->formatter->asDate($modelPerson->birthday,'php:Y'));
                        
        $dates['birthday'] = str_replace("\xE2\x80\x8B", "",$dates['birthday']);
        
        
        ## Position Salary ##
        $modelPosition = $modelPerson->positionSalaries;
        $modelPositionOld = $modelPerson->positionSalaryOlds;
        $dataPositionSaraly = new ArrayDataProvider([
            'allModels' => ArrayHelper::merge($modelPositionOld,$modelPosition),
            'pagination' => false,
            'sort' => [
                'attributes' => ['adjust_date' => SORT_ASC],
            ],
        ]);
        
        
        $content = $this->renderPartial('index', [
        //return $this->renderPartial('print', [
        //$content = $this->renderAjax('print', [
            'dates' => $dates,
            'rowNum' => $rowNum,
            'dataDefect' => $dataDefect,
            'dataPositionSaraly' => $dataPositionSaraly,
            'modelPerson' => $modelPerson,
            'user_id' => $id
        ]);
        
$css = <<< Css
    @page *{
        margin-top: 2.54cm;
        margin-bottom: 2.54cm;
        margin-left: 0cm;
        margin-right: 0cm;
    }
    body{padding:0px;margin:0px;}
    .table-print{ width: 100%; border-spacing: 0px; }
    .table-print th, .table-print td {border-right: #000 1px solid; padding: 8px;line-height: 0.5;vertical-align: top;}
    .table-print th.cell-right,.table-print td.cell-right{ border-right: none; }
    .table-print tr td{ border-bottom: #000 1px dotted; }
    .header-labels th{border-top:#000 1px solid; border-bottom:#000 1px solid;}
    .header-labels-edu th{border-top:#000 1px solid; border-bottom:#000 1px solid;line-height: 0.8;}
    .body-labels-first th{border-top:#000 1px solid;border-bottom:#000 1px solid; line-height: 1;}
    .body-labels th{ border-bottom:#000 1px solid;line-height: 1;}
    .text-underdot{ display:inline-block; padding:5px 5px; margin-bottom:5px; border-bottom: #000 1px dotted;width:auto;}
Css;
        
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            // 'cssFile' => '@frontend/web/css/pdf.css',
            //'cssFile' => '@andahrm/person/views/print/print.css',
            // any css to be embedded if required
            /*'cssInline' => '.table-print {width: 100%; border-spacing: 0px;}
                .table-print th, .table-print td{border-right: #000 1px solid; padding: 8px;line-height: 1.42857143;vertical-align: top;}
                .table-print thead th,{border-top:#000 1px solid;border-bottom:#000 1px solid;}
                .table-print th:nth-child(1), .table-print td:nth-child(1){border-left:#000 1px solid;}',*/
            'cssInline' => $css,
            // set mPDF properties on the fly
            'options' => ['title' => $this->getView()->title.': '.$modelPerson->fullname],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>false,
                'SetFooter'=>false,
            ]
            
        ]);
        //echo $content;
        return $pdf->render();
    }
    
    
    public function actionKoPo7PositionSalary($id)
    {
        //$ss = \andahrm\person\assets\PrintAsset::register($this);
        
        $this->layout = 'view';
        
        $modelPerson =$this->findModel($id);
        
        $rowNum[0] = 8;
        $rowNum[1] = 9;
        $rowNum[2] = 9;
        $rowNum[3] = 39; #position
        $dataDefect = [];
        $modelDefect = $modelPerson->defects;
        for($i = 0;$i<=$rowNum[0];$i++ ){
             //$dataDefect[$i] = null;
            if(isset($modelDefect[$i])){
                $dataDefect[$i] = $modelDefect[$i];
            }
        }
        // echo "<pre>";
        // print_r($dataDefect);
        // exit();
        
        $f = new \NumberFormatter("th", \NumberFormatter::SPELLOUT);
        $dates['birthday'] = $f->format(Yii::$app->formatter->asDate($modelPerson->birthday,"php:d"))
                        ." ".Yii::$app->formatter->asDate($modelPerson->birthday,'php:F')
                        ." ".$f->format(Yii::$app->formatter->asDate($modelPerson->birthday,'php:Y'));
                        
        $dates['birthday'] = str_replace("\xE2\x80\x8B", "",$dates['birthday']);
        
        
        ## Position Salary ##
        $modelPosition = $modelPerson->positionSalaries;
        $modelPositionOld = $modelPerson->positionSalaryOlds;
        $dataPositionSaraly = new ArrayDataProvider([
            'allModels' => ArrayHelper::merge($modelPositionOld,$modelPosition),
            'pagination' => false,
            'sort' => [
                'attributes' => ['adjust_date' => SORT_ASC],
            ],
        ]);
        
        
        $content = $this->renderPartial('position-salary', [
            'rowNum' => $rowNum,
            'models' => $dataPositionSaraly->getModels(),
        ]);
        
$css = <<< Css
    @page *{
        margin-top: 2.54cm;
        margin-bottom: 2.54cm;
        margin-left: 0cm;
        margin-right: 0cm;
    }
    body{padding:0px;margin:0px;}
    .table-print{ width: 100%; border-spacing: 0px; }
    .table-print th, .table-print td {border-right: #000 1px solid; padding: 8px;line-height: 0.5;vertical-align: top;}
    .table-print th.cell-right,.table-print td.cell-right{ border-right: none; }
    .table-print tr td{ border-bottom: #000 1px dotted; }
    .header-labels th{border-top:#000 1px solid; border-bottom:#000 1px solid;}
    .header-labels-edu th{border-top:#000 1px solid; border-bottom:#000 1px solid;line-height: 0.8;}
    .body-labels-first th{border-top:#000 1px solid;border-bottom:#000 1px solid; line-height: 1;}
    .body-labels th{ border-bottom:#000 1px solid;line-height: 1;}
    .text-underdot{ display:inline-block; padding:5px 5px; margin-bottom:5px; border-bottom: #000 1px dotted;width:auto;}
Css;
        
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            // 'cssFile' => '@frontend/web/css/pdf.css',
            //'cssFile' => '@andahrm/person/views/print/print.css',
            // any css to be embedded if required
            /*'cssInline' => '.table-print {width: 100%; border-spacing: 0px;}
                .table-print th, .table-print td{border-right: #000 1px solid; padding: 8px;line-height: 1.42857143;vertical-align: top;}
                .table-print thead th,{border-top:#000 1px solid;border-bottom:#000 1px solid;}
                .table-print th:nth-child(1), .table-print td:nth-child(1){border-left:#000 1px solid;}',*/
            'cssInline' => $css,
            // set mPDF properties on the fly
            'options' => [
                'title' => $this->getView()->title.': '.$modelPerson->fullname,
                'defaultheaderline' => false,
            'defaultfooterline' => false,
            ],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>"<div style='text-align: center; font-style: normal;font-size:14;'>".Yii::t('andahrm/person','13. Position and salary rate.')."</div>",
                'SetFooter'=>"<div style='border-top:1px solid #000;text-align: center; padding-top:10px;font-style: normal;font-size:14;'>
                ๑๔. ".Yii::t('andahrm/person', 'Name')."
                <span class='text-underdot' >&nbsp;&nbsp;&nbsp;&nbsp;".$modelPerson->fullname."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>"
                .Yii::t('andahrm/position-salary', 'Level')."
                 <span class='text-underdot'>&nbsp;&nbsp;&nbsp;&nbsp;".$modelPerson->level."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>"
                 .Yii::t('andahrm/person','ministry')."
                 <span class='text-underdot'>&nbsp;&nbsp;&nbsp;&nbsp;"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>"
                 .Yii::t('andahrm/person','department')."
                 <span class='text-underdot'>&nbsp;&nbsp;&nbsp;&nbsp;"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </div>",
            ],
            
            
        ]);
        return $pdf->render();
    }

}
