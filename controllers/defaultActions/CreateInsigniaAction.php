<?php

namespace andahrm\person\controllers\defaultActions;

use Yii;
use yii\base\Action;
use yii\base\Model;
use andahrm\insignia\models\InsigniaRequest;
use andahrm\insignia\models\InsigniaPerson;
use andahrm\positionSalary\models\PersonPositionSalary;
use andahrm\positionSalary\models\PersonPositionSalaryOld;
use andahrm\edoc\models\Edoc;
use andahrm\structure\models\Position;

class CreateInsigniaAction extends Action {

    //public $findModel;

    public function run($formAction = null, $id, $modal_edoc_id = null) {

        // if(!$formAction){
        //     $this->layout = 'view';
        // }

        $model = $this->controller->findModel($id);
        $modelsInsigniaPerson = [new InsigniaPerson(['user_id' => $id])];
        //$modelsEdoc = [new Edoc(['scenario' => 'insert'])];
        $post = Yii::$app->request->post();
        if ($post) {
            if (Yii::$app->request->isAjax) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            }

            $success = false;
            $result = null;
            $errorMassages = [];

//             print_r($post);
//             exit();
            if (Model::loadMultiple($modelsInsigniaPerson, $post)) {
                //Model::loadMultiple($modelsEdoc, $post);
                //$edoc = $post("Edoc");
                foreach ($modelsInsigniaPerson as $key => $modelSinsignia) {
                    //Try to save the models. Validation is not needed as it's already been done.
                    //echo $modelSinsignia->year;
                    //$modelSinsignia->person_type_id = Position::find()->where(['id' => $modelSinsignia->last_position_id])->select('person_type_id')->scalar();
                    //$modelSinsignia->gender = $model->gender;


                    //$modelEdoc = Edoc::findOne(['id' => $modelSinsignia->edoc_id]);
                    //$modelSinsignia->year = Yii::$app->formatter->asDate($modelEdoc->date_code, 'php:d/m/Y');
                    //@list($d, $m, $year) = @explode('/', $modelSinsignia->year);
                    $modelSinsignia->year = $modelSinsignia->year-543; 
                    $find = [
//                        'person_type_id' => $modelSinsignia->person_type_id,
//                        'insignia_type_id' => $modelSinsignia->insignia_type_id,
//                        'gender' => $modelSinsignia->gender,
//                        'year' => ($year-543),
                        'edoc_insignia_id' => $modelSinsignia->edoc_insignia_id
                    ];
//                                 echo "<pre>";
//                                  print_r($find);
//                                  //print_r($modelsInsigniaPerson);
//                     exit();



                    //$modelSinsignia->last_adjust_date = $modelSinsignia->year;
//                    if($modelSinsignia->edoc_id == null){
//                            $modelsEdoc[$key]->save();
//                            $modelSinsignia->edoc_id = $modelsEdoc[$key]->id;
//                            //exit();
//                    }
                    //echo $modelSinsignia->edoc_id;
//                    print_r($find);
//                    exit();
                    //if ($modelSinsignia->edoc_id) {

//                        if ($modelRequest = InsigniaRequest::find()->where($find)->one()) {
////                             $modelRequest->attributes = $attributes;
////                             $modelRequest->save(false);
//                            $modelSinsignia->insignia_request_id = $modelRequest->id;
//                        } else {
//                            $modelRequest = new InsigniaRequest();
//                            $attributes = [
//                                'person_type_id' => $modelSinsignia->person_type_id,
//                                'insignia_type_id' => $modelSinsignia->insignia_type_id,
//                                'gender' => $modelSinsignia->gender,
//                                'year' => ($year - 543),
//                                'edoc_id' => $modelSinsignia->edoc_id
//                            ];
//                            $modelRequest->attributes = $attributes;
//                            print_r($attributes);
//                            exit();
//                            $modelRequest->save(false);
//                            $modelSinsignia->insignia_request_id = $modelRequest->id;
//                        }
                        $modelSinsignia->attributes = $find;


                        if (!$modelSinsignia->getExists()) {
                            if ($modelSinsignia->save(false)) {
                                $success = true;
                                //  print_r($find);
                                //  exit();
                            } else {
                                $result = $modelSinsignia->attributes;
                                $errorMassages[] = $modelSinsignia->getErrors();
                            }
                        }
                    //}
                }
                if ($errorMassages) {
                    print_r($errorMassages);
                    exit();
                }
            }

            if (Yii::$app->request->isAjax) {
                return [
                    'success' => $success,
                    'result' => $result,
                    'errorMassages' => $errorMassages
                ];
            } else {
                Yii::$app->getSession()->setFlash('saved', [
                    'type' => 'success',
                    'msg' => Yii::t('andahrm', 'Save operation completed.')
                ]);
                return $this->controller->redirect(['view-prestige', 'id' => $id]);
            }
        }

        $options = [
            'model' => $model,
            'models' => $modelsInsigniaPerson,
            'modelsEdoc' => $modelsEdoc,
            'formAction' => $formAction,
            'modal_edoc_id' => $modal_edoc_id
        ];

        if ($formAction) {
            return $this->controller->renderPartial('_form/_insignia', $options);
        } else {
            return $this->controller->render('_form/_insignia', $options);
        }
    }

}
