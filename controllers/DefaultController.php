<?php

namespace andahrm\person\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use andahrm\person\models\Person;
use andahrm\person\models\PersonSearch;
use andahrm\person\models\Detail;
use andahrm\person\models\AddressContact;
use andahrm\person\models\AddressBirthPlace;
use andahrm\person\models\AddressRegister;
use andahrm\person\models\PeopleFather;
use andahrm\person\models\PeopleMother;
use andahrm\person\models\PeopleSpouse;
use andahrm\person\models\PeopleChild;
use andahrm\person\models\ChildModel;

use andahrm\edoc\models\Edoc;

use andahrm\setting\models\Helper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\rbac\DbManager;

use andahrm\person\models\Nationality;
use andahrm\person\models\Race;
use andahrm\setting\models\LocalRegion;

/**
 * DefaultController implements the CRUD actions for Person model.
 */
class DefaultController extends Controller
{
//     public $defaultAction = 'frontpage';
    /**
     * @inheritdoc
     */
    public $races;
    
    public $nationalities;
  
    public $localReligions;
    
    public $formSteps = [
        1 => ['name' =>'1', 'desc' => 'Basic and User account', 'icon' => 'fa fa-info-circle', 'models' => ['Person', 'User']],
        2 => ['name' =>'2', 'desc' => 'Detail', 'icon' => 'fa fa-address-card', 'models' => ['Detail', 'AddressContact', 'AddressRegister', 'AddressBirthPlace']],
        3 => ['name' =>'3', 'desc' => 'Parents', 'icon' => 'fa fa-user-secret', 'models' => ['PeopleFather', 'PeopleMother']],
        4 => ['name' =>'4', 'desc' => 'Childs', 'icon' => 'fa fa-child', 'models' => ['PeopleChild']],
        //'confirm' => ['name' =>'5', 'desc' => 'Confirm', 'models' => []],
    ];
    
    public $sessionKey = 'person-form-data';
    
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
        $session = Yii::$app->session;
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = Yii::$app->params['app-settings']['reading']['pagesize'];
        
        $session->remove($this->sessionKey);

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
        $models['person'] = $this->findModel($id);
//         $models['user'] = $models['person']->user;
        $models['detail'] = ($models['person']->detail !== null ) ? $models['person']->detail : new Detail(['user_id' => $id]);
        $models['address-contact'] = ($models['person']->addressContact !== null ) ? $models['person']->addressContact : new AddressContact(['user_id' => $id]);
        $models['address-birth-place'] = ($models['person']->addressBirthPlace !== null ) ? $models['person']->addressBirthPlace : new AddressBirthPlace(['user_id' => $id]);
        $models['address-register'] = ($models['person']->addressRegister !== null ) ? $models['person']->addressRegister : new AddressRegister(['user_id' => $id]);
        $models['people-father'] = ($models['person']->peopleFather !== null ) ? $models['person']->peopleFather : new PeopleFather(['user_id' => $id]);
        $models['people-mother'] = ($models['person']->peopleMother !== null ) ? $models['person']->peopleMother : new PeopleMother(['user_id' => $id]);
        $models['people-spouse'] = ($models['person']->peopleSpouse !== null ) ? $models['person']->peopleSpouse : new PeopleSpouse(['user_id' => $id]);
//         $models['people-childs'] = $models['person']->peopleChilds;
        
        $post = Yii::$app->request->post();
        if($post) {
            $errorMassages = [];
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($models as $key => $model) {
                    if (array_key_exists($model->formName(), $post)) {
                        if($model->load($post) && $model->save()) {

                        }else{
                            $errorMassages[] = $model->getErrors();
                        }
                    }
                }
                
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

                    return $this->redirect(['view', 'id' => $id]);
                }
            
            }catch(ErrorException $e) {
                Yii::$app->getSession()->setFlash('saved',[
                    'type' => 'error',
                    'title' => Yii::t('andahrm', 'Unable to save record.'),
                    'msg' => $e->getMessage()
                ]);
                $transaction->rollback();
            }
        }
        
        $this->prepareData();
        
        return $this->render('view', ['models' => $models]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
//         $this->layout = 'x_panel';
//         $model = new Person();
        $request = Yii::$app->request;
        $post = Yii::$app->request->post();
        
        $userClass = Yii::$app->user->identityClass;
        $models['user'] = new $userClass();
        $models['user']->scenario = 'create';
        
        $models['person'] = new Person();     
        $models['detail'] = new Detail();
        $models['address-contact'] = new AddressContact();
        $models['address-birth-place'] = new AddressBirthPlace();
        $models['address-register'] = new AddressRegister();
        $models['people-father'] = new PeopleFather();
        $models['people-mother'] = new PeopleMother();
        $models['people-spouse'] = new PeopleSpouse();
        $models['people-childs'] = [new PeopleChild()];
        $models['edoc'] = new Edoc(['scenario' => 'insert']);
        
        if($post){
            $errorMassages = [];
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $models['user']->load($post);
                $models['user']->username = $models['user']->username;
                $models['user']->email = $models['user']->email;
                $models['user']->setPassword($models['user']->newPassword);
                $models['user']->generateAuthKey();
                
                if ($models['user']->save()){
                    foreach($models as $key => $model) {
                        if($key !== 'people-childs' && $key !== 'user'){
                            $model->load($post);
                            $model->user_id = $models['user']->id;
                            if (!$model->save()){
                                $errorMassages[] = $model->getErrors();
                            }
                        }
                    }
                    
                } else {
                    $errorMassages[] = $models['user']->getErrors();
                }
                
                $models['people-childs'] = ChildModel::createMultiple(PeopleChild::classname(), $models['people-childs']);
                ChildModel::loadMultiple($models['people-childs'], $post);

                // validate all models
                $valid = $models['user']->validate();
                $valid = ChildModel::validateMultiple($models['people-childs']) && $valid;
                if($valid){
                    foreach ($models['people-childs'] as $modelChild) {
                        $modelChild->user_id = $models['user']->id;
                        if (! ($flag = $modelChild->save(false))) {
                            $errorMassages[] = $modelChild->getErrors();
                            break;
                        }
                    }
                }else{
                    $errorMassages[] = ['Child in valid.'];
                }
                
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

                    return $this->redirect(['update', 'id' => $models['user']->id]);
                }
                
            }catch(ErrorException $e) {
                Yii::$app->getSession()->setFlash('saved',[
                    'type' => 'error',
                    'title' => Yii::t('andahrm', 'Unable to save record.'),
                    'msg' => $e->getMessage()
                ]);
                $transaction->rollback();
            }
            
        }
        
        $this->prepareData();
            
//         return $this->render('create', ['models' => $models,]); //แสดงทุกอย่างในหน้าเดียว
        return $this->render('wizard/create', ['models' => $models]); //แสดงแบบ Wizard
        //เลือกเปิดเอาว่าชอบแบบใหน
        
    }

    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $session = Yii::$app->session;

        $models['person'] = $this->findModel($id);
        $models['user'] = $models['person']->user;
        $models['detail'] = ($models['person']->detail !== null ) ? $models['person']->detail : new Detail(['user_id' => $id]);
        $models['address-contact'] = ($models['person']->addressContact !== null ) ? $models['person']->addressContact : new AddressContact(['user_id' => $id]);
        $models['address-birth-place'] = ($models['person']->addressBirthPlace !== null ) ? $models['person']->addressBirthPlace : new AddressBirthPlace(['user_id' => $id]);
        $models['address-register'] = ($models['person']->addressRegister !== null ) ? $models['person']->addressRegister : new AddressRegister(['user_id' => $id]);
        $models['people-father'] = ($models['person']->peopleFather !== null ) ? $models['person']->peopleFather : new PeopleFather(['user_id' => $id]);
        $models['people-mother'] = ($models['person']->peopleMother !== null ) ? $models['person']->peopleMother : new PeopleMother(['user_id' => $id]);
        $models['people-spouse'] = ($models['person']->peopleSpouse !== null ) ? $models['person']->peopleSpouse : new PeopleSpouse(['user_id' => $id]);
//         $models['people-childs'] = (!empty($models['person']->peopleChilds)) ? $models['person']->peopleChilds : [new PeopleChild(['user_id' => $id])];
        $models['people-childs'] = $models['person']->peopleChilds;

        
        if($post){
            $errorMassages = [];
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $models['user']->load($post);
                
                if ($models['user']->save()){
                    foreach($models as $key => $model) {
                        if($key !== 'people-childs' && $key !== 'user'){
                            $model->load($post);
                            if (!$model->save()){
                                $errorMassages[] = $model->getErrors();
                            }
                        }
                    }
                } else {
                    $errorMassages[] = $models['user']->getErrors();
                }
                
                $oldIDs = ArrayHelper::map($models['people-childs'], 'id', 'id');
                $models['people-childs'] = ChildModel::createMultiple(PeopleChild::classname(), $models['people-childs']);
                ChildModel::loadMultiple($models['people-childs'], $post);
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($models['people-childs'], 'id', 'id')));

                // validate all models
                $valid = $models['user']->validate();
                $valid = ChildModel::validateMultiple($models['people-childs']) && $valid;
                if($valid){
                    if (!empty($deletedIDs)) {
                        PeopleChild::deleteAll(['id' => $deletedIDs]);
                    }
                    foreach ($models['people-childs'] as $modelChild) {
                        $modelChild->user_id = $models['user']->id;
                        if (! ($flag = $modelChild->save(false))) {
                            $errorMassages[] = $modelChild->getErrors();
                            break;
                        }
                    }
                }else{
                    $errorMassages[] = ['Child in valid.'];
                }
                
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

                    return $this->redirect(['update', 'id' => $models['user']->id]);
                }
                
            }catch(ErrorException $e) {
                Yii::$app->getSession()->setFlash('error',[
                    'type' => 'error',
                    'title' => Yii::t('andahrm', 'Unable to save record.'),
                    'msg' => $e->getMessage()
                ]);
                $transaction->rollback();
            }
            
        }
    
        $models['people-childs'] = (empty($models['people-childs'])) ? [new PeopleChild] : $models['people-childs'];
        
        $this->prepareData();
        
//         return $this->render('update', ['models' => $models]); //แสดงทุกอย่างในหน้าเดียว
        return $this->render('wizard/update', ['models' => $models]); //แสดงแบบ Wizard
        //เลือกเปิดเอาว่าชอบแบบใหน
        
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
    
    protected function saveModels()
    {
        $post = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            return true;

        } catch(ErrorException $e) {
            Yii::$app->getSession()->setFlash('saved',[
                'type' => 'error',
                'title' => Yii::t('andahrm', 'Unable to save record.'),
                'msg' => $e->getMessage()
            ]);
            $transaction->rollback();
        }
    }
    
    public function detailViewAttributes($view, $params)
    {
        extract($params);
        $dir = realpath(__DIR__.'/../views/'.$this->id.'/detail-view');
        return require($dir.'/'.$view.'.php');
    }
    
    public function prepareData()
    {
        $this->races = Race::find()->all();
        
        $this->nationalities = Nationality::find()->all();
        
        $this->localReligions = LocalRegion::find()->all();
    }
    
    public function getStep($point='current')
    {
        $currentStep = Yii::$app->request->get('step');
        if($currentStep === null){
            return null;
        }
        $formSteps = $this->formSteps;
        unset($formSteps[0]);
        $keys = array_keys($formSteps);
        while (current($keys) != $currentStep) next($keys);

        if ($point === 'prev') {
            return prev($keys);
        } elseif ($point === 'next') {
            return next($keys);
        }
        return current($keys);
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
