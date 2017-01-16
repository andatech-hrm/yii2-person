<?php

namespace andahrm\person\controllers;

use Yii;
use andahrm\person\models\Detail;
use andahrm\person\models\DetailSearch;
use andahrm\person\models\AddressBirthPlace;
use andahrm\person\models\AddressRegister;
use andahrm\person\models\AddressContact;
use andahrm\setting\models\Helper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DetailController implements the CRUD actions for Detail model.
 */
class DetailController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action)
    {
        $this->view->params['current-menu'] = \yii\helpers\Url::to(['/person/default']);

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        return true; // or false to not run the action
    }

    /**
     * Lists all Detail models.
     * @return mixed
     */
//     public function actionIndex()
//     {
//         $searchModel = new DetailSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//         return $this->render('index', [
//             'searchModel' => $searchModel,
//             'dataProvider' => $dataProvider,
//         ]);
//     }

    /**
     * Displays a single Detail model.
     * @param integer $id
     * @return mixed
     */
//     public function actionView($id)
//     {
//         return $this->render('view', [
//             'model' => $this->findModel($id),
//         ]);
//     }

    /**
     * Creates a new Detail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($form=null)
    {
        $model = new Detail([
            'nationality_id' => Detail::DEFAULT_NATIONALITY,
            'race_id' => Detail::DEFAULT_RACE,
            'blood_group' => Detail::BLOOD_GRUOP_A
        ]);
        
        $modelAddressContact = new AddressContact();
        
        $modelAddressBirthPlace = new AddressBirthPlace();
        
        $modelAddressRegister = new AddressRegister();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            $params = [
                'model' => $model,
                'modelAddressContact' => $modelAddressContact,
                'modelAddressBirthPlace' => $modelAddressBirthPlace,
                'modelAddressRegister' => $modelAddressRegister,
                'form' => $form,
            ];
            if($form === null){
                return $this->render('create', $params);
            }else{
                return $this->renderPartial('create', $params);
            }
        }
    }

    /**
     * Updates an existing Detail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($form=null, $id)
    {
        $model = $this->findModel($id);
        
        if($model->addressContact !== null) {
            $modelAddressContact = $model->addressContact;
            $modelAddressContact->localRegion = $modelAddressContact->province->region_id;
        } else {
            $modelAddressContact = new AddressContact();
        }
        
        if ($model->addressBirthPlace !== null) {
            $modelAddressBirthPlace = $model->addressBirthPlace;
            $modelAddressBirthPlace->localRegion = $modelAddressBirthPlace->province->region_id;
        }else{
            $modelAddressBirthPlace = new AddressBirthPlace();
        }
        
        if($model->addressRegister !== null) {
            $modelAddressRegister = $model->addressRegister;
            $modelAddressRegister->localRegion = $modelAddressRegister->province->region_id;
        }else{
            $modelAddressRegister = new AddressRegister();
        }

        
        if ($model->load(Yii::$app->request->post())){
            $modelAddressContact->load(Yii::$app->request->post());
            $modelAddressBirthPlace->load(Yii::$app->request->post());
            $modelAddressRegister->load(Yii::$app->request->post());
                
                
            $transaction = Yii::$app->db->beginTransaction();
            try {
//                 if (empty($modelAddressBirthPlace->move_in_date)){
//                     echo 'empty';
//                 }
//                 var_dump($modelAddressBirthPlace->move_in_date); return;
                $errorMassages = [];
                if (!empty($modelAddressContact->move_in_date)){
                    if(!$modelAddressContact->save()) {
                        $errorMassages = array_merge($errorMassages, $modelAddressContact->getErrors());
                    }
                }
                if (!empty($modelAddressBirthPlace->move_in_date)){
                    if (!$modelAddressBirthPlace->save()) {
                        $errorMassages = array_merge($errorMassages, $modelAddressBirthPlace->getErrors());
                    }
                }
                if (!empty($modelAddressRegister->move_in_date)){
                    if (!$modelAddressRegister->save()) {
                        $errorMassages = array_merge($errorMassages, $modelAddressRegister->getErrors());
                    }
                }

                $model->address_contact_id = $modelAddressContact->id;
                $model->address_birth_place_id = $modelAddressBirthPlace->id;
                $model->address_register_id = $modelAddressRegister->id;
                
                if (!$model->save()) {
                    $errorMassages = array_merge($errorMassages, $model->getErrors());
                }
                print_r($errorMassages);
                if(count($errorMassages) > 0){
                    $msg = '<ul>';
                    foreach($errorMassages as $key => $fields){
                        $msg .= '<li>'.implode("<br />", $fields).'</li>';
                    }
                    $msg .= '</ul>';
                    throw new ErrorException($msg);
                }else{
                    Yii::$app->getSession()->setFlash('saved',[
                        'type' => 'success',
                        'msg' => Yii::t('andahrm', 'Save operation completed.')
                    ]);

                    $transaction->commit();

                    return $this->redirect(Helper::urlParams('update'));
                }

            } catch(ErrorException $e) {
                Yii::$app->getSession()->setFlash('saved',[
                    'type' => 'error',
                    'title' => Yii::t('andahrm', 'Unable to save record.'),
                    'msg' => $e->getMessage()
                ]);
                $transaction->rollback();
            }
        } else {
//             return $this->render('update', [
//                 'model' => $model,
//                 'modelAddressContact' => $modelAddressContact,
//                 'modelAddressBirthPlace' => $modelAddressBirthPlace,
//                 'modelAddressRegister' => $modelAddressRegister,
//             ]);
            $params = [
                'model' => $model,
                'modelAddressContact' => $modelAddressContact,
                'modelAddressBirthPlace' => $modelAddressBirthPlace,
                'modelAddressRegister' => $modelAddressRegister,
                'form' => $form,
            ];
            if($form === null){
                return $this->render('update', $params);
            }else{
                return $this->renderPartial('update', $params);
            }
        }
    }

    /**
     * Deletes an existing Detail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Detail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Detail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Detail::findOne($id)) !== null) {
            return $model;
        } else {
            //throw new NotFoundHttpException('The requested page does not exist.');
            
            $defaultValues = [];
            if ($this->action->id === 'create' || $this->action->id === 'update') {
                $defaultValues = [
                    'user_id' => $id,
                    'nationality_id' => Detail::DEFAULT_NATIONALITY,
                    'race_id' => Detail::DEFAULT_RACE,
                    'blood_group' => Detail::BLOOD_GRUOP_A
                ];
            }
            return new Detail($defaultValues);
        }
        
//         return Detail::findOne($id);
    }
}
