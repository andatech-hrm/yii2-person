<?php

namespace andahrm\person\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "person_detail".
 *
 * @property integer $user_id
 * @property integer $nationality_id
 * @property integer $race_id
 * @property integer $religion_id
 * @property string $blood_group
 * @property integer $address_contact_id
 * @property integer $address_birth_place_id
 * @property integer $address_register_id
 * @property string $mother_name
 * @property string $father_name
 * @property integer $married_status
 * @property integer $people_spouse_id
 *
 * @property Address $addressBirthPlace
 * @property Address $addressRegister
 * @property Address $addressContact
 * @property Nationality $nationality
 * @property Person $user
 * @property Race $race
 * @property Religion $religion
 */
class Detail extends \yii\db\ActiveRecord
{
    const DEFAULT_NATIONALITY = 231;
    const DEFAULT_RACE = 99;
    
    const BLOOD_GRUOP_A = 'A';
    const BLOOD_GRUOP_B = 'B';
    const BLOOD_GRUOP_AB = 'AB';
    const BLOOD_GRUOP_O = 'O';
    
    const STATUS_SINGLE = 0;//โสด
    const STATUS_MARRIED = 1;//แต่งงาน
    const STATUS_DIVORCED = 2;//หย่า
    const STATUS_WIDOWED = 3;//หม้าย
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_detail';
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
            [['user_id', 'nationality_id', 'race_id', 'religion_id'], 'required'],
            [['user_id', 'nationality_id', 'race_id', 'religion_id', 'married_status'], 'integer'],
            [['blood_group'], 'string', 'max' => 2],
            [['nationality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nationality::className(), 'targetAttribute' => ['nationality_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['race_id'], 'exist', 'skipOnError' => true, 'targetClass' => Race::className(), 'targetAttribute' => ['race_id' => 'id']],
            [['religion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Religion::className(), 'targetAttribute' => ['religion_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('andahrm/person', 'User ID'),
            'nationality_id' => Yii::t('andahrm/person', 'Nationality'),
            'race_id' => Yii::t('andahrm/person', 'Race'),
            'religion_id' => Yii::t('andahrm/person', 'Religion'),
            'blood_group' => Yii::t('andahrm/person', 'Blood Group'),
            'married_status' => Yii::t('andahrm/person', 'Married Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddressBirthPlace()
    {
        return $this->hasOne(AddressBirthPlace::className(), ['user_id' => 'user_id'])->where(['type' => Address::TYPE_BIRTH_PLACE]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddressRegister()
    {
        return $this->hasOne(AddressRegister::className(), ['user_id' => 'user_id'])->where(['type' => Address::TYPE_REGISTER]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddressContact()
    {
        return $this->hasOne(AddressContact::className(), ['user_id' => 'user_id'])->where(['type' => Address::TYPE_CONTACT]);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReligion()
    {
        return $this->hasOne(Religion::className(), ['id' => 'religion_id']);
    }
    
    
    public static function getBloodGroups()
    {
        return [
            self::BLOOD_GRUOP_A => self::BLOOD_GRUOP_A,
            self::BLOOD_GRUOP_B => self::BLOOD_GRUOP_B,
            self::BLOOD_GRUOP_AB => self::BLOOD_GRUOP_AB,
            self::BLOOD_GRUOP_O => self::BLOOD_GRUOP_O,
        ];
    }
    
    public function getBloodGroupText()
    {
        $arr = self::getBloodGroups();
        if(array_key_exists($this->blood_group, $arr)) {
            return $arr[$this->blood_group];
        }
        return null;
    }
    
    public static function getStatuses()
    {
        return [
            self::STATUS_SINGLE => Yii::t('andahrm/person', 'Single'),
            self::STATUS_MARRIED => Yii::t('andahrm/person', 'Married'),
            self::STATUS_DIVORCED => Yii::t('andahrm/person', 'Divorced'),
            self::STATUS_WIDOWED => Yii::t('andahrm/person', 'Widowed'),
        ];
    }
    
    public function getStatusText()
    {
        $arr = self::getStatuses();
        if(array_key_exists($this->married_status, $arr)) {
            return $arr[$this->married_status];
        }
        return null;
    }
    
    public function getEducation()
    {
        return $this->hasOne(Education::className(), ['id' => 'person_education_id']);
    }
}
