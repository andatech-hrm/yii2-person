<?php

namespace andahrm\person\controllers;

use Yii;
use andahrm\person\models\Person;
use andahrm\person\models\Child;
use andahrm\person\models\ChildSearch;
use andahrm\person\models\People;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use andahrm\setting\models\Helper;

/**
 * ChildController implements the CRUD actions for Child model.
 */
class ChildController extends Controller
{
    public $modelPerson;
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
        $this->modelPerson = Person::findOne(Yii::$app->request->get('id'));

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        return true; // or false to not run the action
    }

    /**
     * Lists all Child models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChildSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelPerson' => $this->modelPerson,
        ]);
    }

    /**
     * Displays a single Child model.
     * @param integer $user_id
     * @param string $people_id
     * @param string $relation
     * @return mixed
     */
    public function actionView($id, $people_id, $relation)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $people_id, $relation),
        ]);
    }

    /**
     * Creates a new Child model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Child([
            'user_id' => $this->modelPerson->user_id,
        ]);
        $modelPeople = new People([
            'nationality_id' => People::DEFAULT_NATIONALITY,
            'race_id' => People::DEFAULT_RACE,
        ]);
        
        if($modelPeople->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())){
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $errorMassages = [];
                if (!$modelPeople->save()) {
                    $errorMassages = array_merge($errorMassages, $modelPeople->getErrors());
                }

                $model->people_id = $modelPeople->id;
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

                    return $this->redirect(Helper::urlParams('index'));
                }

            } catch(ErrorException $e) {
                Yii::$app->getSession()->setFlash('saved',[
                    'type' => 'error',
                    'title' => Yii::t('andahrm', 'Unable to save record.'),
                    'msg' => $e->getMessage()
                ]);
                $transaction->rollback();
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelPeople' => $modelPeople,
            'modelPerson' => $this->modelPerson,
        ]);
    }

    /**
     * Updates an existing Child model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $user_id
     * @param string $people_id
     * @param string $relation
     * @return mixed
     */
    public function actionUpdate($id, $people_id, $relation)
    {
        $model = $this->findModel($id, $people_id, $relation);
        $modelPeople = $model->people;

        if($modelPeople->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())){
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $errorMassages = [];
                if (!$modelPeople->save()) {
                    $errorMassages = array_merge($errorMassages, $modelPeople->getErrors());
                }

                $model->people_id = $modelPeople->id;
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

                    return $this->redirect(Helper::urlParams('index'));
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
            return $this->render('update', [
                'model' => $model,
                'modelPeople' => $model->people,
                'modelPerson' => $this->modelPerson,
            ]);
        }
    }

    /**
     * Deletes an existing Child model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $user_id
     * @param string $people_id
     * @param string $relation
     * @return mixed
     */
    public function actionDelete($user_id, $people_id, $relation)
    {
        $this->findModel($user_id, $people_id, $relation)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Child model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $user_id
     * @param string $people_id
     * @param string $relation
     * @return Child the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id, $people_id, $relation)
    {
        if (($model = Child::findOne(['user_id' => $user_id, 'people_id' => $people_id, 'relation' => $relation])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
