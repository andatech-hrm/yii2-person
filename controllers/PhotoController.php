<?php

namespace andahrm\person\controllers;

use Yii;
use andahrm\person\models\Photo;
use andahrm\person\models\PhotoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PhotoController implements the CRUD actions for Photo model.
 */
class PhotoController extends Controller
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
     * Get Person models.
     * @return mixed
     */
    public function actionIndex($id = null)
    {
        if(is_null($id)) { 
            $id = Yii::$app->user->id;
        }else{
            if(!Yii::$app->user->can('manage-person')){
                throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page.');
            }
        }
        $model = Photo::find()->andWhere(['user_id' => $id])->orderBy(['year' => 'DESC'])->all();
        
        return $this->render('index', ['model' => $model]);
    }

    /**
     * Displays a single Photo model.
     * @param integer $user_id
     * @param string $year
     * @return mixed
     */
    public function actionView($user_id, $year)
    {
        return $this->render('view', [
            'model' => $this->findModel($user_id, $year),
        ]);
    }

    /**
     * Creates a new Photo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($user_id=null)
    {
        if(is_null($user_id)) {
            $user_id = Yii::$app->user->id;
        }else{
            if(!Yii::$app->user->can('manage-person')){
                throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page.');
            }
        }
        $model = new Photo();
        $model->scenario = 'insert';
        $model->user_id = $user_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('saved',[
                'type' => 'success',
                'msg' => Yii::t('andahrm', 'Save operation completed.')
            ]);
            return $this->redirect(['index']);
        } else {
            if(Yii::$app->request->isAjax){
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            }
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Photo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $user_id
     * @param string $year
     * @return mixed
     */
    public function actionUpdate($user_id, $year)
    {
        $model = $this->findModel($user_id, $year);
        $model->scenario = 'update';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('saved',[
                'type' => 'success',
                'msg' => Yii::t('andahrm', 'Save operation completed.')
            ]);
//             return $this->redirect(['view', 'user_id' => $model->user_id, 'year' => $model->year]);
            return $this->redirect(['index']);
        } else {
            if(Yii::$app->request->isAjax){
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Photo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $user_id
     * @param string $year
     * @return mixed
     */
    public function actionDelete($user_id, $year)
    {
        $this->findModel($user_id, $year)->delete();
        Yii::$app->getSession()->setFlash('deleted',[
            'type' => 'success',
            'msg' => Yii::t('andahrm', 'Delete item completed.')
        ]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Photo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $user_id
     * @param string $year
     * @return Photo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id, $year)
    {
        if (($model = Photo::findOne(['user_id' => $user_id, 'year' => $year])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
