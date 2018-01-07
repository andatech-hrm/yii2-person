<?php
namespace andahrm\person\controllers\defaultActions;

use Yii;
use yii\base\Action;
use yii\base\Model;
use andahrm\development\models\DevelopmentPerson;
use andahrm\edoc\models\Edoc;

class CreateDevelopmentAction extends Action{
    
    //public $findModel;

    public function run($formAction=null,$id,$modal_edoc_id=null)
    {
        // if(!$formAction){
        //     $this->layout = 'view';
        // }
        $modelsDevelopmentPersons = [new DevelopmentPerson()];
        $modelsEdoc = [new Edoc(['scenario'=>'insert'])];
        $post = Yii::$app->request->post();
        if($post){
            if(Yii::$app->request->isAjax){
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            }
           
            $success = false;
            $result=null;
            $errorMassages = [];
            
            // print_r($post);
            // exit();
            if(Model::loadMultiple($modelsDevelopmentPersons,$post)){
               
                //$edoc = $post("Edoc");
                 foreach ($modelsDevelopmentPersons as $key => $modelDevelopment ) {
                     if(count($modelDevelopment->dev_activity_char_id)>0){
                         foreach ($modelDevelopment->dev_activity_char_id as $activity_char_id ) {
                        //Try to save the models. Validation is not needed as it's already been done.
                        //echo $modelSinsignia->year;
                        $find=[
                            'user_id' => $id,
                            'dev_project_id' => $modelDevelopment->dev_project_id,
                            'dev_activity_char_id' => $activity_char_id,
                            ];
                            // echo "<pre>";
                            //  print_r($find);
                            //  print_r($modelDevelopment);
                            // exit();
                
                        
                                
                            if($modelDevelopmentPerson = DevelopmentPerson::find()->where($find)->one()){
                                 $modelDevelopmentPerson->attributes = $find;
                                  $modelDevelopmentPerson->start = $modelDevelopment->start;
                                 $modelDevelopmentPerson->end = $modelDevelopment->end;
                                 
                                 if(!$modelDevelopmentPerson->save()){
                                    $result = $modelDevelopmentPerson->attributes;
                                    $errorMassages[] = $modelDevelopmentPerson->getErrors();
                                }
                            }else{
                                $modelDevelopmentPerson = new DevelopmentPerson();
                                $modelDevelopmentPerson->attributes = $find;
                                 $modelDevelopmentPerson->start = $modelDevelopment->start;
                                 $modelDevelopmentPerson->end = $modelDevelopment->end;
                                if(!$modelDevelopmentPerson->save()){
                                    $result = $modelDevelopmentPerson->attributes;
                                    $errorMassages[] = $modelDevelopmentPerson->getErrors();
                                }
                            }
                         }
                           
                    }else{
                        $find=[
                            'user_id' => $id,
                            'dev_project_id' => $modelDevelopment->dev_project_id,
                        ];
                        
                        if($modelDevelopmentPerson = DevelopmentPerson::find()->where($find)->one()){
                             $modelDevelopmentPerson->attributes = $find;
                              $modelDevelopmentPerson->start = $modelDevelopment->start;
                                 $modelDevelopmentPerson->end = $modelDevelopment->end;
                             if(!$modelDevelopmentPerson->save()){
                                $result = $modelDevelopmentPerson->attributes;
                                $errorMassages[] = $modelDevelopmentPerson->getErrors();
                            }
                        }else{
                            $modelDevelopmentPerson = new DevelopmentPerson();
                            $modelDevelopmentPerson->attributes = $find;
                             $modelDevelopmentPerson->start = $modelDevelopment->start;
                                 $modelDevelopmentPerson->end = $modelDevelopment->end;
                            if(!$modelDevelopmentPerson->save()){
                                $result = $modelDevelopmentPerson->attributes;
                                $errorMassages[] = $modelDevelopmentPerson->getErrors();
                            }
                        }
                    }
                }
                    
                
                if($errorMassages){
                    print_r($errorMassages);
                    exit();
                }
            }
            
            if(Yii::$app->request->isAjax){
                return [
                    'success' => $success,
                    'result' => $result,
                    'errorMassages' => $errorMassages,
                    ];
            }else{
                Yii::$app->getSession()->setFlash('saved',[
                        'type' => 'success',
                        'msg' => Yii::t('andahrm', 'Save operation completed.')
                    ]);
                return $this->controller->redirect(['view-development','id'=>$id]);
            }
            }
        
        
        $options = [
                'model' => $this->controller->findModel($id),
                'models' => $modelsDevelopmentPersons,
                'modelsEdoc' => $modelsEdoc,
                'formAction' => $formAction,
                'modal_edoc_id' => $modal_edoc_id
            ];
       
        if($formAction){
            return $this->controller->renderPartial('_form/_development', $options);
        }else{
            return $this->controller->render('_form/_development', $options);
        }
    }
    
}