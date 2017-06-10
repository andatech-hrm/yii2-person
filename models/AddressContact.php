<?php

namespace andahrm\person\models;

use Yii;

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
class AddressContact extends Address
{
    public function init() {
        $this->type = parent::TYPE_CONTACT;
        parent::init();
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->type = parent::TYPE_CONTACT;
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonDetail()
    {
        return $this->hasOne(PersonDetail::className(), ['address_contact_id' => 'id']);
    }
}
