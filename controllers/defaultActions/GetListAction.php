<?php

namespace andahrm\person\controllers\defaultActions;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use andahrm\person\models\Person;

class GetListAction extends Action {

    //public $findModel;

    public function run($q = null, $id = null){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; //กำหนดการแสดงผลข้อมูลแบบ json
        $out = ['results'=>['id'=>'','text'=>'']];
        $model = Person::find();
        if(!is_null($q)){
            $model->andFilterWhere(['like', 'firstname_th', $q]);
            $model->orFilterWhere(['like', 'lastname_th', $q]);
        
            $out['results'] = ArrayHelper::getColumn($model->all(),function($model){
                return ['id'=>$model->user_id,'text'=>$model->fullname];
            });
        }
        return $out;
    }
}
