<?php

namespace andahrm\person\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use kuakling\datepicker\behaviors\DateBuddhistBehavior;
use andahrm\edoc\models\Edoc;

/**
 * This is the model class for table "person_defect".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $date_defect
 * @property string $title
 * @property string $detail
 * @property integer $edoc_id
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 */
class Defect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_defect';
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
            'date_defect' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'date_defect',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'date_defect', 'title', 'edoc_id',], 'required'],
            [['user_id', 'edoc_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['date_defect'], 'safe'],
            [['detail'], 'string'],
            [['title'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/person', 'ID'),
            'user_id' => Yii::t('andahrm/person', 'User'),
            'date_defect' => Yii::t('andahrm/person', 'Date Defect'),
            'title' => Yii::t('andahrm/person', 'Title Defect'),
            'detail' => Yii::t('andahrm/person', 'Detail Defect'),
            'edoc_id' => Yii::t('andahrm/person', 'Edoc'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
        ];
    }
    
    public function getUser(){
        return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
    }
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdoc()
    {
        return $this->hasOne(Edoc::className(), ['id' => 'edoc_id']);
    }
}
