<?php

namespace andahrm\person\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use kartik\mpdf\Pdf;

use andahrm\person\models\User;
use andahrm\person\models\Person;
use andahrm\person\models\Photo;
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
use andahrm\person\models\Education;
use andahrm\person\models\EducationModel;
use andahrm\person\models\EducationLevel;
use andahrm\person\models\LeaveAssign; #mad
use andahrm\positionSalary\models\PersonPositionSalary;
use andahrm\positionSalary\models\PersonPositionSalaryOld;
use andahrm\person\models\Contract;
use andahrm\person\models\Servant;

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
use andahrm\setting\models\Country;

use yii\web\Response;
use yii\widgets\ActiveForm;

## Print ก.พ.7
use andahrm\person\models\Defect;
use common\models\DynamicFormModel;
#use yii\helpers\ArrayHelper;

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
    public $defaultRaceId;
    
    public $nationalities;
    public $defaultNationalityId;
  
    public $localReligions;
    
    public $countries;
    public $defaultCountryId;
    
    public $educationLevels;
    
    public $formSteps = [];
    public $user_id;
    
    protected $modelMany = ['user', 'people-childs', 'educations', 'photos'];
    
    public $sessionKey = 'person-form-data';
    
    public $modelUser;
    public $modelPerson;

    
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
        $this->formSteps = [
            1 => ['name' =>'1', 'desc' => Yii::t('andahrm/person', 'Register'), 'icon' => 'fa fa-info-circle', 'models' => ['Person', 'User']],
            2 => ['name' =>'2', 'desc' => Yii::t('andahrm/person', 'Information'), 'icon' => 'fa fa-info-circle', 'models' =>  [ 'Person', 'Detail','PeopleSpouse', 'AddressContact', 'AddressRegister', 'AddressBirthPlace']],
            3 => ['name' =>'3', 'desc' => Yii::t('andahrm/person', 'Educations'), 'icon' => 'fa fa-graduation-cap', 'models' => ['Education']],
            4 => ['name' =>'4', 'desc' => Yii::t('andahrm/person', 'Family'), 'icon' => 'fa fa-user-secret', 'models' => ['PeopleFather', 'PeopleMother','PeopleChilds']],
            //4 => ['name' =>'4', 'desc' => Yii::t('andahrm/person', 'Position'), 'icon' => 'fa fa-ticket', 'models' => ['PeopleChild']],
            5 => ['name' =>'5', 'desc' => Yii::t('andahrm/person', 'Leave and Person Type'), 'icon' => 'fa fa-bed', 'models' => ['PeopleChild']],
            //7 => ['name' =>'6', 'desc' => Yii::t('andahrm/person', 'User Account'), 'icon' => 'fa fa-key', 'models' => ['PeopleChild']],
        ];
        
    
        if (!parent::beforeAction($action)) {
            return false;
        }
    
        return true; // or false to not run the action
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
        $this->layout = 'view';
        
        $models['person'] = $this->findModel($id);
//         $models['user'] = $models['person']->user;
        $models['photos'] = $models['person']->photos;
        $models['detail'] = ($models['person']->detail !== null ) ? $models['person']->detail : new Detail(['user_id' => $id]);
        $models['address-contact'] = ($models['person']->addressContact !== null ) ? $models['person']->addressContact : new AddressContact(['user_id' => $id]);
        $models['address-birth-place'] = ($models['person']->addressBirthPlace !== null ) ? $models['person']->addressBirthPlace : new AddressBirthPlace(['user_id' => $id]);
        $models['address-register'] = ($models['person']->addressRegister !== null ) ? $models['person']->addressRegister : new AddressRegister(['user_id' => $id]);
        $models['people-father'] = ($models['person']->peopleFather !== null ) ? $models['person']->peopleFather : new PeopleFather(['user_id' => $id]);
        $models['people-mother'] = ($models['person']->peopleMother !== null ) ? $models['person']->peopleMother : new PeopleMother(['user_id' => $id]);
        $models['people-spouse'] = ($models['person']->peopleSpouse !== null ) ? $models['person']->peopleSpouse : new PeopleSpouse(['user_id' => $id]);
        $models['people-childs'] = $models['person']->peopleChilds;
        $models['educations'] = $models['person']->educations;
        
        $request = Yii::$app->request;
        $post = $request->post();
        if($post) {
            $errorMassages = [];
            $transaction = Yii::$app->db->beginTransaction();
            try {
                
                foreach ($models as $key => $model) {
                    if (!in_array($key, $this->modelMany) && array_key_exists($model->formName(), $post)) {
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
                    if($request->post('Roles')){
                        $this->setRoles($models['person']->user_id, $request->post('Roles', []));
                    }
                    
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
        
        
        $models['photos'] = (empty($models['photos'])) ? [new Photo(['user_id' => $models['person']->user_id])] : $models['photos'];
        $models['people-childs'] = (empty($models['people-childs'])) ? [new PeopleChild] : $models['people-childs'];
        $models['educations'] = (empty($models['educations'])) ? [new Education] : $models['educations'];
        
        $this->prepareData();
        
        return $this->render('view', ['models' => $models]);
    }
    
    
    
    
    public function actionViewPosition($id)
    {
        $this->layout = 'view';
        
        // $searchModel = new \andahrm\positionSalary\models\PersonPositionSalarySearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider->query->where(['user_id'=>$id]);
        // $dataProvider->sort->defaultOrder = ['adjust_date'=> SORT_ASC];
        
        $modelPosition = PersonPositionSalary::find()->where(['user_id' => $id])
            ->orderBy(['adjust_date'=> SORT_ASC])
            ->all();
        $modelPositionOld = PersonPositionSalaryOld::find()->where(['user_id' => $id])
            ->orderBy(['adjust_date'=> SORT_ASC])
            ->all();
        
        $data = ArrayHelper::merge($modelPositionOld,$modelPosition);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => false,
            'sort' => [
                'attributes' => ['adjust_date' => SORT_ASC],
            ],
        ]);

        return $this->render('view-position', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user_id' => $id
        ]);
        
        // echo Yii::$app->runAction('profile/position/index');
    }
    
    
    public function actionPrint($id)
    {
        
        //$ss = \andahrm\person\assets\PrintAsset::register($this);
        
        $this->layout = 'view';
        
        $modelPerson =$this->findModel($id);
        
        $modelPosition = PersonPositionSalary::find()->where(['user_id' => $id])
            ->orderBy(['adjust_date'=> SORT_ASC])
            ->all();
        $modelPositionOld = PersonPositionSalaryOld::find()->where(['user_id' => $id])
            ->orderBy(['adjust_date'=> SORT_ASC])
            ->all();
        
        $data = ArrayHelper::merge($modelPositionOld,$modelPosition);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => false,
            'sort' => [
                'attributes' => ['adjust_date' => SORT_ASC],
            ],
        ]);

        
        $rowNum = 8;
        $dataDefect = [];
        $modelDefect = Defect::find()->where(['user_id'=>$id])->all();
        for($i = 0;$i<=$rowNum;$i++ ){
             //$dataDefect[$i] = null;
            if(isset($modelDefect[$i])){
                $dataDefect[$i] = $modelDefect[$i];
            }
        }
        // echo "<pre>";
        // print_r($dataDefect);
        // exit();
        
        $content = $this->renderPartial('print', [
        //$content = $this->renderAjax('print', [
            'rowNum' => $rowNum,
            'dataDefect' => $dataDefect,
            'dataProvider' => $dataProvider,
            'modelPerson' => $modelPerson,
            'user_id' => $id
        ]);
        
$css = <<< Css
    @page *{
        margin-top: 2.54cm;
        margin-bottom: 2.54cm;
        margin-left: 0cm;
        margin-right: 0cm;
    }
    body{padding:0px;margin:0px;}
    .table-print{ width: 100%; border-spacing: 0px; }
    .table-print th, .table-print td {border-right: #000 1px solid; padding: 8px;line-height: 0.5;vertical-align: top;}
    .table-print th.cell-right,.table-print td.cell-right{ border-right: none; }
    .table-print tr td{ border-bottom: #000 1px dotted; }
    .header-labels th{border-top:#000 1px solid; border-bottom:#000 1px solid;}
Css;
        
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            // 'cssFile' => '@frontend/web/css/pdf.css',
            //'cssFile' => '@andahrm/person/views/print/print.css',
            // any css to be embedded if required
            /*'cssInline' => '.table-print {width: 100%; border-spacing: 0px;}
                .table-print th, .table-print td{border-right: #000 1px solid; padding: 8px;line-height: 1.42857143;vertical-align: top;}
                .table-print thead th,{border-top:#000 1px solid;border-bottom:#000 1px solid;}
                .table-print th:nth-child(1), .table-print td:nth-child(1){border-left:#000 1px solid;}',*/
            'cssInline' => $css,
            // set mPDF properties on the fly
            'options' => ['title' => $this->getView()->title.': '.$modelPerson->fullname],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>false,
                'SetFooter'=>false,
            ]
            
        ]);
        //echo $content;
        return $pdf->render();
        
    }
    
    
    public function actionPrintPosition($id)
    {
        $this->layout = 'view';
        
        $modelPerson =$this->findModel($id);
        
        $modelPosition = PersonPositionSalary::find()->where(['user_id' => $id])
            ->orderBy(['adjust_date'=> SORT_ASC])
            ->all();
        $modelPositionOld = PersonPositionSalaryOld::find()->where(['user_id' => $id])
            ->orderBy(['adjust_date'=> SORT_ASC])
            ->all();
        
        $data = ArrayHelper::merge($modelPositionOld,$modelPosition);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => false,
            'sort' => [
                'attributes' => ['adjust_date' => SORT_ASC],
            ],
        ]);

        $content = $this->renderPartial('print-position', [
            'dataProvider' => $dataProvider,
            'modelPerson' => $modelPerson,
            'user_id' => $id
        ]);
        
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            // 'cssFile' => '@frontend/web/css/pdf.css',
            // any css to be embedded if required
            /*'cssInline' => '.table-print {width: 100%; border-spacing: 0px;}
                .table-print th, .table-print td{border-right: #000 1px solid; padding: 8px;line-height: 1.42857143;vertical-align: top;}
                .table-print thead th,{border-top:#000 1px solid;border-bottom:#000 1px solid;}
                .table-print th:nth-child(1), .table-print td:nth-child(1){border-left:#000 1px solid;}',*/
            'cssInline' => '
                .table-print{width: 100%; border-spacing: 0px;border-bottom: #000 1px solid;}
                .table-print td, .table-print th{border-left: #000 1px solid; padding: 8px;line-height: 1.42857143;vertical-align: top;}
                .table-print .cell-right{border-right: #000 1px solid;}
                .header-labels th{border-top:#000 1px solid; border-bottom:#000 1px solid;}
            ',
            // set mPDF properties on the fly
            'options' => ['title' => $this->getView()->title.': '.$modelPerson->fullname],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>['{PAGENO} / {nb}'],
                'SetFooter'=>[Yii::$app->user->identity->username.' '.Yii::$app->formatter->asDateTime('NOW')],
            ]
        ]);
        
        return $pdf->render();
        
    }
    
    public function actionCreatePosition($formAction=null,$id)
    {
        $model = new PersonPositionSalary(['scenario'=>'new-person']);
        $model->user_id = $id;
        $model->status  = 1;
        
        if($model->load(Yii::$app->request->post())){
            $post = Yii::$app->request->post();
            // print_r($post);
            // exit();

            if(!$model->getExists() && $model->save()){
                 Yii::$app->getSession()->setFlash('saved',[
                        'type' => 'success',
                        'msg' => Yii::t('andahrm', 'Save operation completed.')
                    ]);
                return $this->redirect(['view-position','id'=>$model->user_id]);
            }elseif($model->getExists()){
                Yii::$app->getSession()->setFlash('saved',[
                        'type' => 'warning',
                        'msg' => Yii::t('andahrm/person', 'Cannot save! but have data.')
                    ]);
                return $this->redirect(['view-position','id'=>$model->user_id]);
            }else{
                 print_r($model->getErrors());
                 exit();
            }
            
        }


        return $this->render('position/create-position', [
            'model' => $model,
            'formAction' => $formAction
        ]);
    }
    
    public function actionCreatePositionOld($formAction=null,$id)
    {
        $model = new PersonPositionSalaryOld();
        $model->user_id = $id;
        $model->status  = 1;
        if($model->load(Yii::$app->request->post())){
            $post = Yii::$app->request->post();
           // print_r($post);
            //exit();
            $model->position_old_id = $this->chkDb('\andahrm\structure\models\PositionOld',[
                'code'=>$model->position_old_id
                ]);
            
            
            if(!$model->getExists() && $model->save()){
                 Yii::$app->getSession()->setFlash('saved',[
                        'type' => 'success',
                        'msg' => Yii::t('andahrm', 'Save operation completed.')
                    ]);
                return $this->redirect(['view-position','id'=>$model->user_id]);
            }elseif($model->getExists()){
                Yii::$app->getSession()->setFlash('saved',[
                        'type' => 'warning',
                        'msg' => Yii::t('andahrm/person', 'Cannot save! but have data.')
                    ]);
                return $this->redirect(['view-position','id'=>$model->user_id]);
            }else{
                 print_r($model->getErrors());
                 exit();
            }
            
        }
    
        //return $this->renderPartial('position/create-position-old', [
        return $this->render('position/create-position-old', [
            'model' => $model,
            'formAction' => $formAction
        ]);
    }
    
    public function chkDb($tb,$find,$id='id'){
        $key = array_keys($find);
        if($find){
            if($model = $tb::find()->where($find)->one()){
                return $model->$id;
            }elseif($model = $tb::find()->where([$id=>$find[$key[0]]])->one()){
                return $model->$id;
            }else{
                $model = new $tb;
                $model->$key[0] = $find[$key[0]];
                if($model->save()){
                     return $model->$id;
                }else{
                //      print_r($model->getErrors());
                // exit();
                }
            }
        }
    }
    
    public function actionViewDevelopment($id)
    {
        $this->layout = 'view';
        
        $searchModel = new \andahrm\profile\models\SelfDevelopmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['user_id'=>$id]);
        //$dataProvider->sort->defaultOrder = ['development_project.start'=>SORT_DESC];

        return $this->render('view-development', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionViewPrestige($id)
    {
        $this->layout = 'view';
        
        $searchModel = new \andahrm\insignia\models\InsigniaPersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['user_id'=>$id]);
        // $dataProvider->sort->defaultOrder = [
        //     'year'=>SORT_DESC
        //     ];

       
        
        //$dataProvider->sort->defaultOrder = ['development_project.start'=>SORT_DESC];

        return $this->render('view-prestige', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    
    
    
    
    public function actionViewKp($id)
    {
        $this->layout = 'view';
        
        $models['person'] = $this->findModel($id);
        $models['positionSalary'] = PersonPositionSalary::find()
            ->andWhere(['user_id' => $id])
            ->orderBy('adjust_date')
            ->all();
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $models['positionSalary'],
        ]);
        
        return $this->render('view-kp', ['models' => $models, 'dataProvider' => $dataProvider]);
    }
    
    
    public function actionTest(){
        $person = new Person();
        $person->citizen_id = '1-9499-00097-92-1';
        echo $person->citizen_id."<br/>";
        $person->validate();
        echo $person->citizen_id;
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($step=1,$id=null)
    {
       //if(!$s)
        
        
        if($step != 1 && $id==null){
            return $this->redirect(['create','step'=> 1]);
        }elseif(!ArrayHelper::keyExists($step,$this->formSteps)){
            throw new NotFoundHttpException(Yii::t('andahrm','The requested page does not exist.'));
        }elseif($id){
           $this->findModel($id);
           $this->user_id = $id; #Use in layout
           $nextStep = $step + 1;
        }
        
        $this->layout = 'create';
        
        $request = Yii::$app->request;
        $post = Yii::$app->request->post();
        
        ###################################
        $models['User'] = new User();
        $models['User']->scenario = 'create';
        $models['Person'] = new Person();
        // $models['photo'] = new Photo(['scenario' => 'insert']);
        $models['Detail'] = new Detail();
        $models['AddressContact'] = new AddressContact();
        $models['AddressBirthPlace'] = new AddressBirthPlace();
        $models['AddressRegister'] = new AddressRegister();
        $models['PeopleFather'] = new PeopleFather();
        $models['PeopleMother'] = new PeopleMother();
        $models['PeopleSpouse'] = new PeopleSpouse();
        $models['PeopleChilds'] = [new PeopleChild()];
        $models['Educations'] = [new Education(['country_id' => Country::DEFAULT_COUNTRY])];
        // $models['position-salary'] = new PersonPositionSalary(['scenario' => 'new-person']);
        $models['leave'] = new LeaveAssign(); #madone
        // $models['contract'] = new Contract();
        $models['servant'] = new Servant();
        ##################################

        if(Person::findOne($id)){
            $models['User'] = User::findOne($id);
            $models['Person'] = Person::findOne($id);
            
            $skipModel = ['User', 'PeopleChilds', 'Educations'];
            foreach($this->formSteps[$step]['models'] as $modelKey) {
                if(!in_array($modelKey, $skipModel)){
                     $model = '\andahrm\person\models\\'.ucfirst($modelKey);
                     $modelCheck = $model::find()->where(['user_id'=>$id]);
                     switch($modelKey){
                         case "AddressContact": $modelCheck->andWhere(['type'=>AddressContact::TYPE_CONTACT]); break;
                         case "AddressRegister": $modelCheck->andWhere(['type'=>AddressRegister::TYPE_REGISTER]); break;
                         case "AddressBirthPlace": $modelCheck->andWhere(['type'=>AddressContact::TYPE_BIRTH_PLACE]); break;
                         case "PeopleFather": $modelCheck->andWhere(['type'=>PeopleFather::TYPE_FATHER]); break;
                         case "PeopleMother": $modelCheck->andWhere(['type'=>PeopleMother::TYPE_MOTHER]); break;
                     }
                     
                     if($modelCheck->exists())
                     $models[$modelKey] = $modelCheck->one();
                }
            }
            
            switch($step){
                case 3:
                    $models['Educations'] = $models['Person']->educations ? $models['Person']->educations : $models['Educations'];
                break;
                case 4:
                    $models['PeopleChilds'] = $models['Person']->peopleChilds ? $models['Person']->peopleChilds : $models['PeopleChilds'];
                break;
            }
            
             if (Yii::$app->request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                if($res_valid= ActiveForm::validate($models['Person'],$models['User'])){
                    return $res_valid;
                }
                return [];
            }
            
           
            if($post){
                $errorMassages = [];
                
                switch($step){
                    case 2:
                        //print_r($post);
                        
                         foreach($this->formSteps[$step]['models'] as $model) {
                             $modelKey = null;
                             $modelKey = $model;
                             if(!in_array($modelKey, $skipModel) && $models[$modelKey]->load($post)){
                                $models[$modelKey]->user_id = $models['User']->id;
                                // echo $model->formName();
                                // print_r($model->attributes);
                                if (!$models[$modelKey]->save()){
                                    $errorMassages[] = $models[$modelKey]->getErrors();
                                }
                            }
                        }
                    break;
                    
                     case 3:
                        $saveEducations = $this->createDynamicForm($models['Educations'], EducationModel::className(), $models['User']);
                        if($saveEducations[0] === false) {
                            $errorMassages[] = $saveEducations[1];
                        }
                     break;
                    
                    case 4:
                        #Father & Mother
                        foreach($this->formSteps[$step]['models'] as $model) {
                             $modelKey = null;
                             $modelKey = $model;
                             if(!in_array($modelKey, $skipModel) && $models[$modelKey]->load($post)){
                                $models[$modelKey]->user_id = $models['User']->id;
                                if (!$models[$modelKey]->save()){
                                    $errorMassages[] = $models[$modelKey]->getErrors();
                                }
                            }
                        }
                        
                        #Childs
                        $saveChilds = $this->createDynamicForm($models['PeopleChilds'], ChildModel::className(), $models['User']);
                        if($saveChilds[0] === false) {
                            $errorMassages[] = $saveChilds[1];
                        }
                     break;
                     
                   
                  
                }
                
                
                
                
                
                
                
                if($post['next']){
                    //exit();
                    // echo $nextStep;
                    // echo $models['Person']->user_id;
                    // exit();
                    Yii::$app->getSession()->setFlash('saved',[
                        'type' => 'success',
                        'msg' => Yii::t('andahrm', 'Save operation completed.')
                    ]);
                    return $this->redirect(['create','step'=> $nextStep,'id' => $models['Person']->user_id]);
                }elseif($post['finish']){
                    Yii::$app->getSession()->setFlash('saved',[
                        'type' => 'success',
                        'msg' => Yii::t('andahrm', 'Save operation completed.')
                    ]);
                    return $this->redirect(['view','id' => $models['Person']->user_id]);
                }
            }
       
        }elseif($step==1){
            if($models['Person']->load($post) && $models['User']->load($post)){
                 
                    if (Yii::$app->request->isAjax){
                        Yii::$app->response->format = Response::FORMAT_JSON;
                        if($res_valid= ActiveForm::validate($models['Person'],$models['User'])){
                            return $res_valid;
                        }
                        return [];
                    }
            }
            
            
             if($models['Person']->load($post)&&$models['User']->load($post)){
                 
                   
                    $models['User']->username = $models['User']->username;
                    $models['User']->email = $models['User']->email;
                    $models['User']->setPassword($models['User']->newPassword);
                    $models['User']->generateAuthKey();
                    
                    if ($models['User']->save()){
                        $this->setRoles($models['User']->id, $request->post('Roles', []));
                        $models['Person']->user_id = $models['User']->id;
                        if($models['Person']->save()){
                             if($post['next']){
                                Yii::$app->getSession()->setFlash('saved',[
                                    'type' => 'success',
                                    'msg' => Yii::t('andahrm', 'Save operation completed.')
                                ]);
                                return $this->redirect(['create','step'=> $nextStep,'id' => $models['User']->id]);
                            }
                        }
                    }
             }
        }
        $this->prepareData();
         
        return $this->render('tab/create', ['models' => $models,'step'=>$step]); 
    }
    
   protected function createStep1(){
       
   }
    
    
    
    
    protected function createDynamicForm($models, $multipleModel, $mainModel)
    {
        $errorMassages = [];
        $success = true;
        
        $post = Yii::$app->request->post();
        $className = $models[0]::className();
        
        $oldIDs = ArrayHelper::map($models, 'id', 'id');
        $models = DynamicFormModel::createMultiple($className, $models);
        DynamicFormModel::loadMultiple($models, $post);
        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($models, 'id', 'id')));
        
        // $oldIDs = ArrayHelper::map($modelsOptionValue, 'id', 'id');
        // $modelsOptionValue = Model::createMultiple(OptionValue::classname(), $modelsOptionValue);
        // Model::loadMultiple($modelsOptionValue, Yii::$app->request->post());
        // $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsOptionValue, 'id', 'id')));
        
        // validate all models
        $valid = $mainModel->validate();
        $valid = $multipleModel::validateMultiple($models) && $valid;
        if($valid){
            
            if (!empty($deletedIDs)) {
                $flag = $className::deleteAll(['id'=>$deletedIDs]);
            }
            
            foreach ($models as $model) {
                $model->user_id = $mainModel->id;
                if (! ($flag = $model->save(false))) {
                    $errorMassages[] = $model->getErrors();
                    break;
                }
            }
        }else{
            $errorMassages[] = ['Child in valid.'];
        }
        
        return [$success, $errorMassages];
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
        // $session = Yii::$app->session;

        $models['person'] = $this->findModel($id);
        $models['user'] = $models['person']->user;
        $models['photos'] = $models['person']->photos;
        $models['detail'] = ($models['person']->detail !== null ) ? $models['person']->detail : new Detail(['user_id' => $id]);
        $models['address-contact'] = ($models['person']->addressContact !== null ) ? $models['person']->addressContact : new AddressContact(['user_id' => $id]);
        $models['address-birth-place'] = ($models['person']->addressBirthPlace !== null ) ? $models['person']->addressBirthPlace : new AddressBirthPlace(['user_id' => $id]);
        $models['address-register'] = ($models['person']->addressRegister !== null ) ? $models['person']->addressRegister : new AddressRegister(['user_id' => $id]);
        $models['people-father'] = ($models['person']->peopleFather !== null ) ? $models['person']->peopleFather : new PeopleFather(['user_id' => $id]);
        $models['people-mother'] = ($models['person']->peopleMother !== null ) ? $models['person']->peopleMother : new PeopleMother(['user_id' => $id]);
        $models['people-spouse'] = ($models['person']->peopleSpouse !== null ) ? $models['person']->peopleSpouse : new PeopleSpouse(['user_id' => $id]);
//         $models['people-childs'] = (!empty($models['person']->peopleChilds)) ? $models['person']->peopleChilds : [new PeopleChild(['user_id' => $id])];
        $models['people-childs'] = $models['person']->peopleChilds;
        $models['educations'] = $models['person']->educations;
        $models['position-salary'] = ($models['person']->positionSalary !== null ) ? $models['person']->positionSalary : new PersonPositionSalary(['scenario' => 'new-person', 'user_id' => $id]);
        $models['leave'] = new LeaveAssign(); #madone

        
        if($post){
            $errorMassages = [];
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $models['user']->load($post);
                
                $skipModel = ['user', 'people-childs', 'educations', 'photo'];
                if ($models['user']->save()){
                    foreach($models as $key => $model) {
                        if(!in_array($key, $skipModel)){
                            // echo $key . ' = ' . $model->attributes."<br />";
                            $model->load($post);
                            if (!$model->save()){
                                $errorMassages[] = $model->getErrors();
                            }
                        }
                    }
                } else {
                    $errorMassages[] = $models['user']->getErrors();
                }
                
                
                $models['people-childs'] = (empty($models['people-childs'])) ? [new PeopleChild] : $models['people-childs'];
                $saveChilds = $this->updateDynamicForm($models['people-childs'], ChildModel::className(), $models['user']);
                if($saveChilds[0] === false) {
                    $errorMassages[] = $saveChilds[1];
                }
                
                $models['educations'] = (empty($models['educations'])) ? [new Education] : $models['educations'];
                $saveEducations = $this->updateDynamicForm($models['educations'], EducationModel::className(), $models['user']);
                if($saveEducations[0] === false) {
                    $errorMassages[] = $saveEducations[1];
                }
                
                if(count($errorMassages) > 0){
                    $msg = '<ul>';
                        foreach($errorMassages as $key => $fields){
                            $msg .= '<li>'.implode("<br />", $fields).'</li>';
                        }
                    $msg .= '</ul>';
                    throw new ErrorException($msg);
                }else{
                    $this->setRoles($models['user']->id, $request->post('Roles', []));
                    
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
        $models['educations'] = (empty($models['educations'])) ? [new Education] : $models['educations'];
        
        $this->prepareData();
        
//         return $this->render('update', ['models' => $models]); //แสดงทุกอย่างในหน้าเดียว
        return $this->render('wizard/update', ['models' => $models]); //แสดงแบบ Wizard
        //เลือกเปิดเอาว่าชอบแบบใหน
        
    }
    
    protected function updateDynamicForm($models, $multipleModel, $mainModel)
    {
        $errorMassages = [];
        $success = true;
        $oldIDs = array_filter(ArrayHelper::map($models, 'id', 'id'));
        $post = Yii::$app->request->post();
        
        $models = $multipleModel::createMultiple($models[0]::className(), $models);
        $multipleModel::loadMultiple($models, $post);
        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($models, 'id', 'id')));
        // print_r($oldIDs);
        // Yii::$app->end();

        // validate all models
        $valid = $mainModel->validate();
        $valid = $multipleModel::validateMultiple($models) && $valid;
        if($valid){
            if (!empty($deletedIDs)) {
                $modelClass = $models[0]->className();
                $modelClass::deleteAll(['id' => $deletedIDs]);
            }
            foreach ($models as $model) {
                $model->user_id = $mainModel->id;
                if (! ($flag = $model->save(false))) {
                    $errorMassages[] = $model->getErrors();
                    break;
                }
            }
        }else{
            $errorMassages[] = ['Child in valid.'];
        }
        
        return [$success, $errorMassages];
    }

    /**
     * Deletes an existing Person model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();
        $this->findModel($id)->softDelete();

        // return $this->redirect(['index']);
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
    
    public function detailViewAttributes($view, $params)
    {
        extract($params);
        $dir = realpath(__DIR__.'/../views/'.$this->id.'/detail-view');
        return require($dir.'/'.$view.'.php');
    }
    
    public function prepareData()
    {
        $this->races = Race::find()->all();
        $this->defaultRaceId = Race::DEFAULT_RACE;
        
        $this->nationalities = Nationality::find()->all();
        $this->defaultNationalityId = Nationality::DEFAULT_NATIONALITY;
        
        $this->localReligions = LocalRegion::find()->all();
        
        $this->educationLevels = EducationLevel::find()->all();
        
        $this->countries = Country::find()->all();
        $this->defaultCountryId = Country::DEFAULT_COUNTRY;
    }
    
    // public function getStep($point='current')
    // {
    //     $currentStep = Yii::$app->request->get('step');
    //     if($currentStep === null){
    //         return null;
    //     }
    //     $formSteps = $this->formSteps;
    //     unset($formSteps[0]);
    //     $keys = array_keys($formSteps);
    //     while (current($keys) != $currentStep) next($keys);

    //     if ($point === 'prev') {
    //         return prev($keys);
    //     } elseif ($point === 'next') {
    //         return next($keys);
    //     }
    //     return current($keys);
    // }
    
    protected function setRoles($id, $checkedRoles=[])
    {
        $auth = Yii::$app->authManager;
            
        $systemRoles = $auth->getRoles();
        $keyUserRoles = array_keys($auth->getRolesByUser($id));
        foreach($systemRoles as $key => $systemRole) {
            //echo $key;
            if(in_array($key, $checkedRoles)){
                // echo ' Checked';
                if(in_array($key, $keyUserRoles)){
                    //echo ' No action';
                }else{
                    //echo ' Add this';
                    $role = $auth->getRole($key);
                    $auth->assign($role, $id);
                }
            }else{
                //echo ' No Check';
                if(in_array($key, $keyUserRoles)){
                    //echo ' Remove this';
                    $role = $auth->getRole($key);
                    $auth->revoke($role, $id);
                }
            }
        }
        // Yii::$app->end();
    }
    
    
    public function actionChildCreate($person_id)
    {
        $model = new PeopleChild();
        $model->user_id = $person_id;
        if(Yii::$app->request->post()){
            if($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('saved',[
                    'type' => 'success',
                    'msg' => Yii::t('andahrm', 'Save operation completed.')
                ]);
                return $this->redirect(['view', 'id' => $person_id]);
            }else{
                Yii::$app->getSession()->setFlash('error',[
                    'type' => 'error',
                    'title' => Yii::t('andahrm', 'Unable to save record.'),
                    'msg' => $e->getMessage()
                ]);
            }
        }
        
        $this->prepareData();
        return $this->renderAjax('child-create', ['model' => $model]);
    }
    
    public function actionChildUpdate($id, $person_id)
    {
        $model = PeopleChild::findOne($id);
        if(Yii::$app->request->post()){
            if($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('saved',[
                    'type' => 'success',
                    'msg' => Yii::t('andahrm', 'Save operation completed.')
                ]);
                return $this->redirect(['view', 'id' => $person_id]);
            }else{
                Yii::$app->getSession()->setFlash('error',[
                    'type' => 'error',
                    'title' => Yii::t('andahrm', 'Unable to save record.'),
                    'msg' => $e->getMessage()
                ]);
            }
        }
        
        $this->prepareData();
        return $this->renderAjax('child-update', ['model' => $model]);
    }
    
    public function actionChildDelete($id, $person_id)
    {
        $model = PeopleChild::findOne($id);
        if($model->delete()){
            Yii::$app->getSession()->setFlash('deleted',[
                'type' => 'success',
                'msg' => Yii::t('andahrm', 'Delete operation completed.')
            ]);
        }else{
            Yii::$app->getSession()->setFlash('error',[
                'type' => 'error',
                'msg' => Yii::t('andahrm', 'Unable to delete record.'),
            ]);
        }
        
        return $this->redirect(['view', 'id' => $person_id]);
    }
    
    
    
    
    
    public function actionEducationCreate($person_id)
    {
        $model = new Education();
        $model->user_id = $person_id;
        if(Yii::$app->request->post()){
            if($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('saved',[
                    'type' => 'success',
                    'msg' => Yii::t('andahrm', 'Save operation completed.')
                ]);
                return $this->redirect(['view', 'id' => $person_id]);
            }else{
                Yii::$app->getSession()->setFlash('error',[
                    'type' => 'error',
                    'title' => Yii::t('andahrm', 'Unable to save record.'),
                    'msg' => $e->getMessage()
                ]);
            }
        }
        
        $this->prepareData();
        return $this->renderAjax('education-create', ['model' => $model]);
    }
    
    public function actionEducationUpdate($id, $person_id)
    {
        $model = Education::findOne($id);
        if(Yii::$app->request->post()){
            if($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('saved',[
                    'type' => 'success',
                    'msg' => Yii::t('andahrm', 'Save operation completed.')
                ]);
                return $this->redirect(['view', 'id' => $person_id]);
            }else{
                Yii::$app->getSession()->setFlash('error',[
                    'type' => 'error',
                    'title' => Yii::t('andahrm', 'Unable to save record.'),
                    'msg' => $e->getMessage()
                ]);
            }
        }
        
        $this->prepareData();
        return $this->renderAjax('education-update', ['model' => $model]);
    }
    
    public function actionEducationDelete($id, $person_id)
    {
        $model = Education::findOne($id);
        if($model->delete()){
            Yii::$app->getSession()->setFlash('deleted',[
                'type' => 'success',
                'msg' => Yii::t('andahrm', 'Delete operation completed.')
            ]);
        }else{
            Yii::$app->getSession()->setFlash('error',[
                'type' => 'error',
                'msg' => Yii::t('andahrm', 'Unable to delete record.'),
            ]);
        }
        
        return $this->redirect(['view', 'id' => $person_id]);
    }
    
    
    
    
    
    public function actionPhotoCreate($id)
    {
        $model = new Photo();
        $model->scenario = 'insert';
        $model->user_id = $id;
        if(Yii::$app->request->post()){
            if($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('saved',[
                    'type' => 'success',
                    'msg' => Yii::t('andahrm', 'Save operation completed.')
                ]);
            }else{
                Yii::$app->getSession()->setFlash('error',[
                    'type' => 'error',
                    'msg' => Yii::t('andahrm', 'Unable to save record.'),
                ]);
            }
            
            return $this->redirect(['view', 'id' => $id]);
        }
        
        $this->prepareData();
        return $this->renderAjax('photo-create', ['model' => $model]);
    }
    
    public function actionPhotoUpdate($id, $year)
    {
        $model = Photo::find()->where(['user_id' => $id])->andWhere(['year' => $year])->one();
        $model->scenario = 'update';
        if(Yii::$app->request->post()){
            if($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('saved',[
                    'type' => 'success',
                    'msg' => Yii::t('andahrm', 'Save operation completed.')
                ]);
            }else{
                Yii::$app->getSession()->setFlash('error',[
                    'type' => 'error',
                    'title' => Yii::t('andahrm', 'Unable to save record.'),
                    'msg' => $e->getMessage()
                ]);
            }
            
            return $this->redirect(['view', 'id' => $id]);
        }
        
        $this->prepareData();
        return $this->renderAjax('photo-update', ['model' => $model]);
    }
    
    public function actionPhotoDelete($id, $person_id)
    {
        $model = Education::findOne($id);
        if($model->delete()){
            Yii::$app->getSession()->setFlash('deleted',[
                'type' => 'success',
                'msg' => Yii::t('andahrm', 'Delete operation completed.')
            ]);
        }else{
            Yii::$app->getSession()->setFlash('error',[
                'type' => 'error',
                'msg' => Yii::t('andahrm', 'Unable to delete record.'),
            ]);
        }
        
        return $this->redirect(['view', 'id' => $person_id]);
    }
    
    public function actionCheckUsername($firstname_en,$lastname_en){
         $userClass = Yii::$app->user->identityClass;
         $username = $firstname_en;
         $index = 0;
         while($userClass::find()->where(['username'=>$username])->exists()){
             $char = str_split($lastname_en);
             if($index == 0){
                $username .='.'.$char[$index];
             }else{
                $username .=(isset($char[$index])?$char[$index]:$index);
             }
             $index++;
         }
         return $username;
    }
    

}
