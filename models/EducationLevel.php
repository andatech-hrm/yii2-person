<?php

namespace andahrm\person\models;

use Yii;

/**
 * This is the model class for table "person_education_level".
 *
 * @property integer $id
 * @property string $title
 *
 * @property PersonEducation[] $personEducations
 */
class EducationLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_education_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/education', 'ID'),
            'title' => Yii::t('andahrm/education', 'Title Level'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonEducations()
    {
        return $this->hasMany(PersonEducation::className(), ['level_id' => 'id']);
    }
    
    public static function getAll()
    {
        return self::find()->all();
    }
    
    
    public $count_person;
}
