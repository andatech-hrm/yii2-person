<?php

namespace andahrm\person\models;

use Yii;

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
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'citizen_id', 'firstname_th', 'lastname_th', 'firstname_en', 'lastname_en', 'phone', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
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
            'citizen_id' => Yii::t('andahrm/person', 'รหัสบัตรประชาชน'),
            'title_id' => Yii::t('andahrm/person', 'Title ID'),
            'firstname_th' => Yii::t('andahrm/person', 'ชื่อ'),
            'lastname_th' => Yii::t('andahrm/person', 'นามสกุล'),
            'firstname_en' => Yii::t('andahrm/person', 'Firstname En'),
            'lastname_en' => Yii::t('andahrm/person', 'Lastname En'),
            'gender' => Yii::t('andahrm/person', 'เพศ'),
            'tel' => Yii::t('andahrm/person', 'เบอร์ติดต่อ'),
            'phone' => Yii::t('andahrm/person', 'เบอร์มือถือ'),
            'birthday' => Yii::t('andahrm/person', 'Birthday'),
            'created_at' => Yii::t('andahrm/person', 'Created At'),
            'created_by' => Yii::t('andahrm/person', 'Created By'),
            'updated_at' => Yii::t('andahrm/person', 'Updated At'),
            'updated_by' => Yii::t('andahrm/person', 'Updated By'),
        ];
    }
    
    public function getFullname($lang = 'th')
    {
        if($lang === 'th'){
            return $this->firstname_th.' '.$this->lastname_th;
        }
        return $this->firstname_en.' '.$this->lastname_en;
    }
}
