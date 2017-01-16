<?php
namespace andahrm\person\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use andahrm\person\models\Person;

/**
 * DefaultController implements the CRUD actions for Person model.
 */
class DefaultController extends Controller
{
    public $layout = '@andahrm/person/views/layouts/main';
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
        $model = $this->findModel($id);
        
        return $this->render('index', ['model' => $model]);
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
