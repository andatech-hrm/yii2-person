<?php

namespace andahrm\person\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class CompetencyInformationController extends \yii\web\Controller
{
    
    public function actions(){
        $this->layout = 'competency';    
    }
    
    
    public function actionIndex($file=1)
    {
        
        
        if(!file_exists(Yii::getAlias("@uploads")."/competency/competency-{$file}.pdf")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        $menuItems[] =  [
            "label" => Yii::t('andahrm/competency','Set Competency'),
            "url" => ["/person/competency-information/index",'file'=>1],
            "icon" => "fa fa-users",
            //'active' => (strpos($this->context->route,'report/person') !== false)?true:false
        ];
        $menuItems[] =  [
            "label" => Yii::t('andahrm/competency','Main Competency'),
            "url" => ["/person/competency-information/index",'file'=>2],
            "icon" => "fa fa-users",
            //'active' => (strpos($this->context->route,'report/person') !== false)?true:false
        ];
        $menuItems[] =  [
            "label" => Yii::t('andahrm/competency','Manager Competency'),
            "url" => ["/person/competency-information/index",'file'=>3],
            "icon" => "fa fa-users",
            //'active' => (strpos($this->context->route,'report/person') !== false)?true:false
        ];
        $menuItems[] =  [
            "label" => Yii::t('andahrm/competency','Line Competency'),
            "url" => ["/person/competency-information/index",'file'=>4],
            "icon" => "fa fa-users",
            //'active' => (strpos($this->context->route,'report/person') !== false)?true:false
        ];
        
        
        
        return $this->render('index',['file'=>$file,'menuItems'=>$menuItems]);
    }

}
