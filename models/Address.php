<?php

namespace andahrm\person\models;

use Yii;
use yii\db\ActiveRecord;
use andahrm\setting\models\Helper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use andahrm\datepicker\behaviors\DateBuddhistBehavior;

/**
 * This is the model class for table "person_address".
 *
 * @property integer $id
 * @property integer $number_registration
 * @property integer $number
 * @property string $sub_road
 * @property string $road
 * @property integer $tambol_id
 * @property integer $amphur_id
 * @property integer $province_id
 * @property integer $postcode
 * @property string $phone
 * @property string $fax
 * @property string $move_in_date
 * @property string $move_out_date
 *
 * @property PersonDetail[] $personDetails
 * @property PersonDetail[] $personDetails0
 * @property PersonDetail[] $personDetails1
 */
class Address extends ActiveRecord
{
    const TYPE_CONTACT = 1;
    const TYPE_REGISTER = 2;
    const TYPE_BIRTH_PLACE = 3;
    
    public $localRegion;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_address';
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
            'move_in_date' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'move_in_date',
            ],
            'move_out_date' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'move_out_date',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tambol_id', 'amphur_id', 'province_id', 'postcode'], 'integer'],
            // [['move_in_date'], 'required'],
            [['tambol_id', 'amphur_id', 'province_id', 'postcode', 'move_in_date', 'move_out_date'], 'safe'],
            [['sub_road', 'road'], 'string', 'max' => 50],
            [['number_registration'], 'string', 'max' => 20],
            [['number'], 'string', 'max' => 10],
            [['phone', 'fax'], 'string', 'max' => 9],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/person', 'ID'),
            'localRegion' => Yii::t('andahrm/person', 'Local Region'),
            'number_registration' => Yii::t('andahrm/person', 'Number Registration'),
            'number' => Yii::t('andahrm/person', 'Number'),
            'sub_road' => Yii::t('andahrm/person', 'Sub Road'),
            'road' => Yii::t('andahrm/person', 'Road'),
            'tambol_id' => Yii::t('andahrm/person', 'Tambol'),
            'amphur_id' => Yii::t('andahrm/person', 'Amphur'),
            'province_id' => Yii::t('andahrm/person', 'Province'),
            'postcode' => Yii::t('andahrm/person', 'Postcode'),
            'phone' => Yii::t('andahrm/person', 'Phone'),
            'fax' => Yii::t('andahrm/person', 'Fax'),
            'move_in_date' => Yii::t('andahrm/person', 'Move In Date'),
            'move_out_date' => Yii::t('andahrm/person', 'Move Out Date'),
            'addressText' => Yii::t('andahrm/person', 'Address Text'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonDetails()
    {
        return $this->hasMany(PersonDetail::className(), ['address_register_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonDetails0()
    {
        return $this->hasMany(PersonDetail::className(), ['address_birth_place_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonDetails1()
    {
        return $this->hasMany(PersonDetail::className(), ['address_contact_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTambol()
    {
        return $this->hasOne(\andahrm\setting\models\LocalTambol::className(), ['id' => 'tambol_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAmphur()
    {
        return $this->hasOne(\andahrm\setting\models\LocalAmphur::className(), ['id' => 'amphur_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(\andahrm\setting\models\LocalProvince::className(), ['id' => 'province_id']);
    }
    
    public function getAddressText()
    {
        $notSet = '<span class="not-set">'.Yii::t('yii', '(not set)').'</span>';
        $arr[] = $this->number;
        $arr[] = 'ซ.'.$this->sub_road;
        $arr[] = 'ถ.'.$this->road;
        $arr[] = ($this->tambol) ? 'ต.'.$this->tambol->name : 'ต.'.$notSet;
        $arr[] = ($this->amphur) ? 'อ.'.$this->amphur->name : 'อ.'.$notSet;
        $arr[] = ($this->province) ? 'จ.'.$this->province->name : 'จ.'.$notSet;
        
        return implode(" ", $arr);
    }
}
