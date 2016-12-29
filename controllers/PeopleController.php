<?php

namespace andahrm\person\controllers;

use Yii;
use andahrm\person\models\Person;
use andahrm\person\models\PersonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rbac\DbManager;

/**
 * DefaultController implements the CRUD actions for Person model.
 */
class PeopleController extends Controller
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

    /**
     * Lists all Person models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
                'modelUser' => $modelUser
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('saved',[
                'type' => 'success',
                'msg' => Yii::t('andahrm', 'Save operation completed.')
            ]);
            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
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
}
