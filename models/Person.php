<?php

namespace andahrm\person\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use andahrm\setting\models\Helper;

use andahrm\leave\models\LeavePermission; #mad
use andahrm\positionSalary\models\PersonPositionSalary; #mad
use andahrm\leave\models\LeaveRelatedPerson; #mad

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
class Person extends \yii\db\ActiveRecord
{
    const GENDER_MALE = 'm';
    const GENDER_FEMAIL = 'f';
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
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'citizen_id', 'firstname_th', 'lastname_th', 'firstname_en', 'lastname_en', 'gender', 'phone'], 'required'],
            [['user_id', 'title_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['gender'], 'string'],
            [['birthday'], 'safe'],
            [['citizen_id'], 'string', 'max' => 13],
            [['firstname_th', 'lastname_th', 'firstname_en', 'lastname_en'], 'string', 'max' => 100],
            [['tel', 'phone'], 'string', 'max' => 50],
            [['citizen_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->user->identityClass, 'targetAttribute' => ['user_id' => 'id']],
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
            'created_at' => Yii::t('andahrm/person', 'Created At'),
            'created_by' => Yii::t('andahrm/person', 'Created By'),
            'updated_at' => Yii::t('andahrm/person', 'Updated At'),
            'updated_by' => Yii::t('andahrm/person', 'Updated By'),
        ];
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $date = \DateTime::createFromFormat(Helper::UI_DATE_FORMAT, $this->birthday);
            $this->birthday = $date->format(Helper::DB_DATE_FORMAT);
            return true;
        } else {
            return false;
        }
    }
    
    public function afterFind()
    {
        $date = \DateTime::createFromFormat(Helper::DB_DATE_FORMAT, $this->birthday);
        $this->birthday = $date->format(Helper::UI_DATE_FORMAT);
    }
    
    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }
    
    public function getPerson()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['user_id' => 'user_id']);
    }
    
    public function getCreatedBy()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'created_by']);
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
    
    public function getFullname($lang = 'th')
    {
        if($lang === 'th'){
            return $this->firstname_th.' '.$this->lastname_th;
        }
        return $this->firstname_en.' '.$this->lastname_en;
    }
    
    public static function getRoleList()
    {
        $list = [];
        foreach(Yii::$app->authManager->getRoles() as $role) {
            $list[$role->name] = (!empty($role->description)) ? $role->description : ucfirst($role->name);
        }
        
        return $list;
    }
    
    public static function getGenders()
    {
        return [
            self::GENDER_MALE => Yii::t('app', 'Male'),
            self::GENDER_FEMAIL => Yii::t('app', 'Female'),
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
      return ArrayHelper::map(self::find()->all(),'user_id','fullname');
    }
  
  # Create by mad
  public $year;
  
  /**
  *  Create by mad
  * ข้อมูลสิทธิลา
  */
  public function getLeavePermission()
    {
        return $this->hasOne(LeavePermission::className(), ['user_id' => 'user_id'])
          ->orderBy(['year'=>SORT_DESC]);
    } 
  
   /**
  *  Create by mad
  * ข้อมูลสิทธิลา
  */
   public function getLeavePermissionByYear()
    {
        $year = date('Y');
      $get = Yii::$app->request->get();
      $year=isset($get['PersonSearch']['year'])?$get['PersonSearch']['year']:$year;
        return $this->hasOne(LeavePermission::className(), ['user_id' => 'user_id'])
          ->where('leave_permission.year = :year', [':year' => $year]);
          //->orderBy('leave_permission.year');
    } 
  
  /**
  *  Create by mad
  * ผู้ที่เกี่ยวข้องกับการลาของฉัน
  */
  public function getLeaveRelatedPerson()
    {
        return $this->hasOne(LeaveRelatedPerson::className(), ['user_id' => 'user_id']);
    }
  
  /**
  *  Create by mad
  * เงินเดือนและตำแหน่ง
  */
   public function getPositionSalary()
    {
        return $this->hasOne(PersonPositionSalary::className(), ['user_id' => 'user_id'])->orderBy(['adjust_date'=>SORT_DESC]);
    }
  
  /**
  *  Create by mad
  * ตำแหน่ง
  */
  public function getPosition()
    {
        return $this->positionSalary?$this->positionSalary->position:null;
    }
  
   public function getPositionTitle()
    {
        return $this->position?$this->position->title:null;
    }
  

  
  
}
