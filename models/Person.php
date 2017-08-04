<?php

namespace andahrm\person\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use andahrm\datepicker\behaviors\DateBuddhistBehavior;
use andahrm\setting\models\Helper;

use andahrm\leave\models\LeavePermission; #mad
use andahrm\positionSalary\models\PersonContract; #mad
use andahrm\positionSalary\models\PersonContractOld; #mad
use andahrm\positionSalary\models\PersonPositionSalary; #mad
use andahrm\positionSalary\models\PersonPositionSalaryOld; #mad
use andahrm\leave\models\LeaveRelatedPerson; #mad
use andahrm\person\PersonApi;

/**
 * This is the model class for table "person".
 *
 * @property integer $user_id
 * @property string $citizen_id
 * @property integer $title_id
 * @property string $firstname_th
 * @property string $lastname_th
 * @property string $firstname_en
 * @property string $lastname_en
 * @property string $gender
 * @property string $tel
 * @property string $phone
 * @property string $birthday
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class Person extends ActiveRecord
{
    const GENDER_MALE = 'm';
    const GENDER_FEMAIL = 'f';
    
    public $full_address_contact;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person';
    }
    
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_VALIDATE => 'citizen_id',
                ],
                'value' => function ($event) {
                    return str_replace('-','',$this->citizen_id);
                },
            ],
            'birthday' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'birthday',
            ],
            'full_address_contact' =>[
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => 'full_address_contact',
                ],
                'value' => function($event) {
                    $model = $this->addressContact;
                    return $model?$model->addressText:$model;
                },
            ],
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    // 'deleted_at' => date('Y-m-d H:i:s')
                    'deleted_at' => time()
                ],
                'restoreAttributeValues' => [
                    'deleted_at' => null
                ]
            ],
        ];
    }

    public static function find()
    {
        return parent::find()
            // ->joinWith(['category cat', 'createdBy.profile prof'])
            ->where(['deleted_at' => null]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'firstname_th', 'lastname_th', 'firstname_en', 'lastname_en', 'gender', 'birthday', 'citizen_id'], 'required'],
            [['user_id', 'title_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['gender'], 'string'],
            //[['citizen_id'], 'match', 'pattern' => '/^\d{17}$/'],
            [['citizen_id'], 'match', 'pattern' => '/\b\d{1}[-]?\d{4}[-]?\d{5}[-]?\d{2}[-]?\d{1}$/'],
            [['firstname_th', 'lastname_th', 'firstname_en', 'lastname_en'], 'string', 'max' => 100],
            [['tel', 'phone'], 'string', 'max' => 50],
            [['citizen_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->user->identityClass, 'targetAttribute' => ['user_id' => 'id']],
            [['full_address_contact', 'phone'], 'safe'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('andahrm/person', 'User ID'),
            'citizen_id' => Yii::t('andahrm/person', 'Citizen ID'),
            'title_id' => Yii::t('andahrm/person', 'Title ID'),
            'firstname_th' => Yii::t('andahrm/person', 'Firstname'),
            'lastname_th' => Yii::t('andahrm/person', 'Lastname'),
            'firstname_en' => Yii::t('andahrm/person', 'Firstname En'),
            'lastname_en' => Yii::t('andahrm/person', 'Lastname En'),
            'gender' => Yii::t('andahrm/person', 'Gender'),
            'tel' => Yii::t('andahrm/person', 'Tel'),
            'phone' => Yii::t('andahrm/person', 'Phone'),
            'birthday' => Yii::t('andahrm/person', 'Birthday'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
            'fullname' => Yii::t('andahrm/person', 'Fullname'),
            'fullname_th' => Yii::t('andahrm/person', 'Fullname TH'),
            'fullname_en' => Yii::t('andahrm/person', 'Fullname EN'),
            'full_address_contact' => Yii::t('andahrm/person', 'full_address_contact'),
        ];
    }
    
    // public function beforeSave($insert)
    // {
    //     if (parent::beforeSave($insert)) {
    //         if($birthday = \DateTime::createFromFormat(Helper::UI_DATE_FORMAT, $this->birthday)) {
    //             $this->birthday = $birthday->format(Helper::DB_DATE_FORMAT);
    //         }
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
    
    // public function afterFind()
    // {
    //     if($birthday = \DateTime::createFromFormat(Helper::DB_DATE_FORMAT, $this->birthday)){
    //         $this->birthday = Helper::dateBuddhist($birthday);
    //         //$this->birthday = $birthday->format(Helper::UI_DATE_FORMAT);
    //     }
    // }
    
    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }
    
    public function getCreatedBy()
    {
        //return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'created_by']);
        return PersonApi::instance($this->created_by);
    }
    
    public function getUpdatedBy()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'updated_by']);
    }
    
    public function getTitle()
    {
        return $this->hasOne(Title::className(), ['id' => 'title_id']);
    }
    
    public function getDetail()
    {
        return $this->hasOne(Detail::className(), ['user_id' => 'user_id']);
    }
    
    public function getAddressContact()
    {
        return $this->hasOne(AddressContact::className(), ['user_id' => 'user_id'])->where(['type' => Address::TYPE_CONTACT]);
    }
    
    public function getAddressText($type = Address::TYPE_CONTACT, $fields = [])
    {
        switch ($type) {
            case Address::TYPE_BIRTH_PLACE : $address = $this->addressBirthPlace;
                break;
            case Address::TYPE_REGISTER : $address = $this->addressRegister;
                break;
            default : $address = $this->addressContact;
                break;
        }
        if($address === null) { return null; }
        
        
        $defaultFields = [
            'number_registration' => false,
            'number' => true,
            'sub_road' => true,
            'road' => true,
            'tambol' => true,
            'amphur' => true,
            'province' => true,
            'postcode' => false,
            'phone' => false,
            'fax' => false,
            'move_in_date' => false,
            'move_out_date' => false
        ];
        
        $showFields = array_merge($defaultFields, $fields);
        $arr[] = ($showFields['number_registration']) ? $address->number_registration : '';
        $arr[] .= ($showFields['number']) ? $address->number : '';
        $arr[] .= ($showFields['sub_road']) ? 'ซ.'.$address->sub_road : '';
        $arr[] .= ($showFields['road']) ? 'ถ.'.$address->road : '';
        $arr[] .= ($showFields['tambol']) ? 'ต.'.$address->tambol->name : '';
        $arr[] .= ($showFields['amphur']) ? 'อ.'.$address->amphur->name : '';
        $arr[] .= ($showFields['province']) ? 'จ.'.$address->province->name : '';
        $arr[] .= ($showFields['postcode']) ? $address->postcode : '';
        $arr[] .= ($showFields['phone']) ? 'โทร.'.$address->phone : '';
        $arr[] .= ($showFields['fax']) ? 'แฟกซ์.'.$address->fax : '';
        $arr[] .= ($showFields['move_in_date']) ? 'วันที่ย้ายเข้า '.$address->move_in_date : '';
        $arr[] .= ($showFields['move_out_date']) ? 'วันที่ย้ายออก '.$address->move_out_date : '';
        
        return implode(" ", $arr);
    }
    
    public function getAddressRegister()
    {
        return $this->hasOne(AddressRegister::className(), ['user_id' => 'user_id'])->where(['type' => Address::TYPE_REGISTER]);
    }
    
    public function getAddressBirthPlace()
    {
        return $this->hasOne(AddressBirthPlace::className(), ['user_id' => 'user_id'])->where(['type' => Address::TYPE_BIRTH_PLACE]);
    }
    
    public function getPeopleFather()
    {
        return $this->hasOne(PeopleFather::className(), ['user_id' => 'user_id'])->where(['type' => People::TYPE_FATHER]);
    }
    
    public function getPeopleMother()
    {
        return $this->hasOne(PeopleMother::className(), ['user_id' => 'user_id'])->where(['type' => People::TYPE_MOTHER]);
    }
    
    public function getPeopleSpouse()
    {
        return $this->hasOne(PeopleSpouse::className(), ['user_id' => 'user_id'])->where(['type' => People::TYPE_SPOUSE]);
    }
    
    public function getPeopleChilds()
    {
        return $this->hasMany(PeopleChild::className(), ['user_id' => 'user_id'])->andOnCondition(['type' => People::TYPE_CHILD]);
    }
    
    public function getEducations()
    {
        return $this->hasMany(Education::className(), ['user_id' => 'user_id']);
    }
    
    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['user_id' => 'user_id']);
    }
    
    public function getPhotoLast($original=false)
    {
        $photoLast = Photo::find()
            ->where(['user_id' => $this->user_id])
            ->orderBy(['year' => SORT_DESC])
            ->one();
        
        if ($photoLast === null) {
            return null;
        }
        
        if($original){
            return $photoLast->getUploadUrl('image');
        }
        
        return $photoLast->getUploadUrl('image_cropped');
    }
    
    public $noImg='no-pic.jpg';
    
    public function getPhoto()
    {
        if($this->getPhotoLast()){
            return $this->getPhotoLast();
        }else{
            return '/uploads/'.$this->noImg;
        }
    }
    
    
    public function getFullname($lang = 'th')
    {
        if($lang === 'th'){
            return $this->firstname_th.' '.$this->lastname_th;
        }
        return $this->firstname_en.' '.$this->lastname_en;
    }
    
    public function getInfoMedia($link = '#', $options = [])
    {
        $options = array_replace_recursive([
            'wrapper' => true,
            'wrapperTag' => 'div'
        ], $options);
        
        $inner = '<a class="pull-left border-dark profile_thumb" style="padding:0;">' . 
            '<img src="' .$this->getPhotoLast() . '" class="img-circle" style="width:100%;">' .
            '</a>' .
            '<div class="media-body">' .
            Html::a($this->fullname, $link, ['class' => 'title']) .
            //'<p><strong>$2300. </strong> ' . current($this->getRoles()) . ' </p>' .
            '<p class="position">' . $this->positionTitle . '</p>' .
            //'<p> <small>12 Sales Today</small></p>' .
            '</div>' . 
            '<div class="clearfix"></div>';
        
        if($options['wrapper']) {
            return Html::tag($options['wrapperTag'], $inner, ['class' => 'media event']);
        }
        
        return $inner;
    }
    
    public static function getRoleList()
    {
        $list = [];
        foreach(Yii::$app->authManager->getRoles() as $role) {
            $list[$role->name] = (!empty($role->description)) ? $role->description : ucfirst($role->name);
        }
        
        return $list;
    }
    
    
    public function getRoles()
    {
        $roles = [];
        foreach (Yii::$app->authManager->getRolesByUser($this->user_id) as $key => $role) {
            $roles[$key] = ucfirst($role->description);
        }
        
        return $roles;
    }
    
    
    public static function getGenders()
    {
        return [
            self::GENDER_MALE => Yii::t('andahrm/person', 'Male'),
            self::GENDER_FEMAIL => Yii::t('andahrm/person', 'Female'),
        ];
    }
    
    public function getGenderText()
    {
        $genders = self::getGenders();
        if(array_key_exists($this->gender, $genders)){
            return $genders[$this->gender];
        }
        return null;
    }
    
  
  # Create by mad
    public static function getList(){
      return ArrayHelper::map(self::find()->all(),'user_id','fullname','positionTitle');
    }
  
  # Create by mad
  //public $year;
  
  
  
  /**
  *  Create by mad
  * ผู้ที่เกี่ยวข้องกับการลาของฉัน
  */
  public function getLeaveRelatedPerson()
    {
        return $this->hasOne(LeaveRelatedPerson::className(), ['user_id' => 'user_id']);
    }
    
    /**
     * สัญญาจ้าง
     * 
     */ 
    public function getPersonContract()
    {
        return $this->hasOne(PersonContract::className(), ['user_id' => 'user_id'])->orderBy(['start_date'=>SORT_DESC]);
    }
  
 
    public function getPersonContracts()
    {
        return $this->hasMany(PersonContract::className(), ['user_id' => 'user_id'])->orderBy(['start_date'=>SORT_DESC]);
    }
    
    public function getPersonContractOlds()
    {
        return $this->hasMany(PersonContractOld::className(), ['user_id' => 'user_id'])->orderBy(['start_date'=>SORT_DESC]);
    }
    
     /**
  *  Create by mad
  * เงินเดือนและตำแหน่ง
  */
    
    public function getPositionSalary()
    {
        return $this->hasOne(PersonPositionSalary::className(), ['user_id' => 'user_id'])->orderBy(['adjust_date'=>SORT_DESC]);
    }
    
    public function getPositionSalaries()
    {
        return $this->hasMany(PersonPositionSalary::className(), ['user_id' => 'user_id'])->orderBy(['adjust_date'=>SORT_ASC]);
    }
    
    
    public function getPositionSalaryOlds()
    {
        return $this->hasMany(PersonPositionSalaryOld::className(), ['user_id' => 'user_id'])->orderBy(['adjust_date'=>SORT_DESC]);
    }
  
    /**
    *  Create by mad
    * ตำแหน่ง
    */
    public function getPosition()
    {
        return $this->positionSalary?$this->positionSalary->position:null;
    }
    
    public function getLevel()
    {
        return $this->positionSalary?$this->positionSalary->level:null;
    }
    
    public function getPositionOld()
    {
        return $this->positionSalaryOl?$this->positionSalary->position:null;
    }
  
    public function getPositionTitle()
    {
        return $this->position?$this->position->title:null;
    }
  
    public function getSectionTitle()
    {
        return $this->positionSalary?$this->positionSalary->position->section->title:null;
    }
    
    public function getNumberCitizenId(){
        return str_replace('-','',$this->citizen_id);
    }
    
    /**
     * Relation Defect
     * 
     */
  
    public function getDefects(){
        return $this->hasMany(Defect::className(),['user_id'=>'user_id'])->orderBy(['date_defect'=>SORT_DESC]);
    }
  
}
