<?php

namespace andahrm\person\controllers;

use Yii;
use andahrm\person\models\Person;
use andahrm\person\models\PersonSearch;
use andahrm\person\models\Detail;
use andahrm\setting\models\Helper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rbac\DbManager;

/**
 * DefaultController implements the CRUD actions for Person model.
 */
class DefaultController extends Controller
{
//     public $defaultAction = 'frontpage';
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

    /**
     * Lists all Person models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$this->layout = '@andahrm/person/views/layouts/frontpage';
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = Yii::$app->params['app-settings']['reading']['pagesize'];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Person model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
//         $this->layout = 'x_panel';
        $model = new Person();
        
        $userClass = Yii::$app->user->identityClass;
        $modelUser = new $userClass();
        $modelUser->scenario = 'create';

        if ($model->load(Yii::$app->request->post())) {
            $modelUser->load(Yii::$app->request->post());
            $modelUser->setPassword($modelUser->newPassword);
            $modelUser->generateAuthKey();
            $modelUser->save();
            
            
            $model->user_id = $modelUser->id;
            $model->save();
            
            $auth = new DbManager;
            $role = $auth->getRole(Yii::$app->request->post('role'));
            $auth->assign($role, $modelUser->id);
            
            $modelUser->profile->firstname = $model->firstname_th;
            $modelUser->profile->lastname = $model->lastname_th;
            $modelUser->profile->save();
            
            Yii::$app->getSession()->setFlash('saved',[
                'type' => 'success',
                'msg' => Yii::t('andahrm', 'Save operation completed.')
            ]);
            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            print_r($model->getErrors());
            return $this->render('create', [
                'model' => $model,
                'modelUser' => $modelUser,
            ]);
        }
    }

    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $modelUser = $model->user;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $hasError = [];
            $modelUser->load(Yii::$app->request->post());
            $modelUser->save();
            
            if (!Yii::$app->runAction('/person/detail/update', ['id' => $model->user_id])){
                $hasError[] = 'Update detail error.';
            }
            
            if(count($hasError) == 0){
                Yii::$app->getSession()->setFlash('saved',[
                    'type' => 'success',
                    'msg' => Yii::t('andahrm', 'Save operation completed.'),
                ]);
                return $this->redirect(Helper::urlParams('update'));
            }else{
                Yii::$app->getSession()->setFlash('save-fail',[
                    'type' => 'error',
                    'msg' => implode("<br />\n", $hasError),
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelUser' => $modelUser,
            ]);
        }
    }

    /**
     * Deletes an existing Person model.
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
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
//     private function getModelDetail($model)
//     {
//         if (is_null($model->detail)) {
//             $modelDetail = new Detail();
//             $modelDetail->user_id = $model->user_id;
//             $modelDetail->nationality_id = Detail::DEFAULT_NATIONALITY;
//             $modelDetail->race_id = Detail::DEFAULT_RACE;
//             $modelDetail->blood_group = Detail::BLOOD_GRUOP_A;
//         }else{ 
//             $modelDetail = $model->detail;
//         }
//         return $modelDetail;
//     }
}
