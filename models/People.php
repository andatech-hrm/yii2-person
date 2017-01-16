<?php

namespace andahrm\person\models;

use Yii;
use andahrm\setting\models\Helper;

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
 */
class People extends \yii\db\ActiveRecord
{
    const DEFAULT_NATIONALITY = 171;
    
    const DEFAULT_RACE = 99;
    
    const LIVE_STATUS_YES = 1;
    const LIVE_STATUS_NO = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'people';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['birthday'], 'safe'],
            [['nationality_id', 'race_id'], 'integer'],
            [['citizen_id'], 'string', 'max' => 20],
            [['name', 'surname', 'live_status'], 'string', 'max' => 255],
            [['occupation'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/person', 'ID'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild()
    {
        return $this->hasOne(Child::className(), ['people_id' => 'id']);
    }
    
    public static function getLiveStatuses()
    {
        return [
            self::LIVE_STATUS_YES => Yii::t('andahrm/person', 'Alive'),
            self::LIVE_STATUS_NO => Yii::t('andahrm/person', 'Die'),
        ];
    }
    
    public function getLiveStatus()
    {
        $liveStatus = self::getLiveStatuses();
        if(array_key_exists($this->live_status, $liveStatus)){
            $liveStatus[$this->live_status];
        }
        return null;
    }
}
