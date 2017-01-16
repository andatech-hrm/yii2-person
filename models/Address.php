<?php

namespace andahrm\person\models;

use Yii;
use andahrm\setting\models\Helper;

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
class Address extends \yii\db\ActiveRecord
{
    
    public $localRegion;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tambol_id', 'amphur_id', 'province_id', 'postcode'], 'integer'],
//             [['move_in_date'], 'required'],
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
            'number_registration' => Yii::t('andahrm/person', 'เลขทะเบียนบ้าน'),
            'number' => Yii::t('andahrm/person', 'เลขที่บ้าน'),
            'sub_road' => Yii::t('andahrm/person', 'Sub Road'),
            'road' => Yii::t('andahrm/person', 'Road'),
            'tambol_id' => Yii::t('andahrm/person', 'ตำบล'),
            'amphur_id' => Yii::t('andahrm/person', 'อำเภอ'),
            'province_id' => Yii::t('andahrm/person', 'จังหวัด'),
            'postcode' => Yii::t('andahrm/person', 'รหัสไปษณีรย์'),
            'phone' => Yii::t('andahrm/person', 'Phone'),
            'fax' => Yii::t('andahrm/person', 'Fax'),
            'move_in_date' => Yii::t('andahrm/person', 'Move In Date'),
            'move_out_date' => Yii::t('andahrm/person', 'Move Out Date'),
        ];
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(!empty($this->move_in_date)) {
                $move_in_date = \DateTime::createFromFormat(Helper::UI_DATE_FORMAT, $this->move_in_date);
                $this->move_in_date = $move_in_date->format(Helper::DB_DATE_FORMAT);
            }
            
            if(!empty($this->move_out_date)) {
                $move_out_date = \DateTime::createFromFormat(Helper::UI_DATE_FORMAT, $this->move_out_date);
                $this->move_out_date = $move_out_date->format(Helper::DB_DATE_FORMAT);
            }
            return true;
        } else {
            return false;
        }
    }
    
    public function afterFind()
    {
        if(!empty($this->move_in_date)) {
            $move_in_date = \DateTime::createFromFormat(Helper::DB_DATE_FORMAT, $this->move_in_date);
            $this->move_in_date = $move_in_date->format(Helper::UI_DATE_FORMAT);
        }
        
        if(!empty($this->move_out_date)) {
            $move_out_date = \DateTime::createFromFormat(Helper::DB_DATE_FORMAT, $this->move_out_date);
            $this->move_out_date = $move_out_date->format(Helper::UI_DATE_FORMAT);
        }
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
}
