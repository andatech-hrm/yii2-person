<?php

namespace andahrm\person\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
###
use andahrm\person\models\PersonRetired;
use andahrm\person\models\PersonRetiredSearch;
use andahrm\person\models\Person;

/**
 * RetiredController implements the CRUD actions for PersonRetired model.
 */
class RetiredController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all PersonRetired models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PersonRetiredSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PersonRetired model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PersonRetired model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PersonRetired();

        if ($model->load(Yii::$app->request->post())) {
            if ($modelPerson = Person::findOne(['user_id' => $model->user_id])) {
                $model->last_position_id = $modelPerson->position_id;
                $modelPerson->status = 0;
                $modelPerson->position_id = null;

                if ($model->save() && $modelPerson->save()) {
                    return $this->redirect(['view', 'id' => $model->user_id]);
                }
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing PersonRetired model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PersonRetired model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PersonRetired model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PersonRetired the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PersonRetired::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('andahrm/person', 'The requested page does not exist.'));
    }

}
