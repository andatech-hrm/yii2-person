<?php

namespace andahrm\person\controllers;

use Yii;
use andahrm\person\models\Person;
use andahrm\person\models\People;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use andahrm\setting\models\Helper;
use andahrm\person\models\Nationality;
use andahrm\person\models\Race;

use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ChildController implements the CRUD actions for Child model.
 */
class ChildController extends Controller
{
    public $modelPerson;
    
    public $races;
    
    public $nationalities;
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
        $modelPerson = new Person;
        $modelsPeople = [new People(['user_id' => 3])];

        if ($modelPerson->load(Yii::$app->request->post())) {

            $modelsPeople = Model::createMultiple(Address::classname());
            Model::loadMultiple($modelsPeople, Yii::$app->request->post());

            // validate all models
            $valid = $modelPerson->validate();
            $valid = Model::validateMultiple($modelsPeople) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $modelPerson->save(false)) {
                        foreach ($modelsPeople as $modelPeople) {
                            $modelPeople->user_id = $modelPerson->user_id;
                            if (! ($flag = $modelPeople->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelPerson->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            //'modelPerson' => $modelPerson,
            'modelsPeople' => $modelsPeople
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
    public function actionUpdate($id)
    {
        $modelPerson = $this->findModel($id);
        $modelsPeople = $modelPerson->peopleChilds;

        if ($modelPerson->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsPeople, 'user_id', 'user_id');
            $modelsPeople = Model::createMultiple(Address::classname(), $modelsPeople);
            Model::loadMultiple($modelsPeople, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsPeople, 'id', 'id')));

            // validate all models
            $valid = $modelPerson->validate();
            $valid = Model::validateMultiple($modelsPeople) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelPerson->save(false)) {
                        if (!empty($deletedIDs)) {
                            Address::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsPeople as $modelPeople) {
                            $modelPeople->customer_id = $modelPerson->user_id;
                            if (! ($flag = $modelPeople->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelPerson->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'modelPerson' => $modelPerson,
            'modelsPeople' => (empty($modelsPeople)) ? [new People] : $modelsPeople
        ]);
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
    protected function findModel($user_id)
    {
        if (($model = Person::findOne(['user_id' => $user_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function prepareData()
    {
        $this->races = Race::find()->all();
        
        $this->nationalities = Nationality::find()->all();
    }
}
