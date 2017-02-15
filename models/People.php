<?php

namespace andahrm\person\models;

use Yii;
use andahrm\setting\models\Helper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "people".
 *
 * @property integer $id
 * @property string $citizen_id
 * @property string $name
 * @property string $surname
 * @property string $birthday
 * @property integer $nationality_id
 * @property integer $race_id
 * @property string $occupation
 * @property string $live_status
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 */
class People extends \yii\db\ActiveRecord
{
    const DEFAULT_NATIONALITY = 171;
    
    const DEFAULT_RACE = 99;
    
    const LIVE_STATUS_YES = 1;
    const LIVE_STATUS_NO = 0;
    
    const TYPE_FATHER = 1;
    const TYPE_MOTHER = 2;
    const TYPE_SPOUSE = 3;
    const TYPE_CHILD = 4;
    
    public function init()
    {
        parent::init();
        
        //if($this->isNewRecord) {
            $this->race_id = self::DEFAULT_RACE;
            $this->nationality_id = self::DEFAULT_NATIONALITY;
        //}
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'people';
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
            [['birthday'], 'safe'],
            [['nationality_id', 'race_id', 'user_id', 'type', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['citizen_id'], 'string', 'max' => 20],
            [['name', 'surname', 'live_status'], 'string', 'max' => 255],
            [['occupation'], 'string', 'max' => 100],
//             [['birthday'], 'default', 'value' => null],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/person', 'ID'),
            'user_id' => Yii::t('andahrm/person', 'User ID'),
            'type' => Yii::t('andahrm/person', 'Type'),
            'citizen_id' => Yii::t('andahrm/person', 'Citizen ID'),
            'name' => Yii::t('andahrm/person', 'Name'),
            'surname' => Yii::t('andahrm/person', 'Surname'),
            'birthday' => Yii::t('andahrm/person', 'Birthday'),
            'nationality_id' => Yii::t('andahrm/person', 'Nationality ID'),
            'race_id' => Yii::t('andahrm/person', 'Race ID'),
            'occupation' => Yii::t('andahrm/person', 'อาชีพ'),
            'live_status' => Yii::t('andahrm/person', 'มีชีวิต/เสียชีวิต'),
        ];
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->birthday) {
                $birthday = \DateTime::createFromFormat(Helper::UI_DATE_FORMAT, $this->birthday);
                $this->birthday = $birthday->format(Helper::DB_DATE_FORMAT);
            }
            return true;
        } else {
            return false;
        }
    }
    
    public function afterFind()
    {
        if($this->birthday) {
            $birthday = \DateTime::createFromFormat(Helper::DB_DATE_FORMAT, $this->birthday);
            $this->birthday = $birthday->format(Helper::UI_DATE_FORMAT);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild()
    {
        return $this->hasOne(Child::className(), ['people_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNationality()
    {
        return $this->hasOne(Nationality::className(), ['id' => 'nationality_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRace()
    {
        return $this->hasOne(Race::className(), ['id' => 'race_id']);
    }
    
    public static function getLiveStatuses()
    {
        return [
            self::LIVE_STATUS_YES => Yii::t('andahrm/person', 'Alive'),
            self::LIVE_STATUS_NO => Yii::t('andahrm/person', 'Die'),
        ];
    }
    
    public function getLiveStatusText()
    {
        $liveStatus = self::getLiveStatuses();
        $status = intval($this->live_status);
        
        return (isset($liveStatus[$status])) ? $liveStatus[$status] : null;
    }
    
    public function getFullname()
    {
        return $this->name . ' ' . $this->surname;
    }
}
