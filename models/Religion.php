<?php

namespace andahrm\person\models;

use Yii;

/**
 * This is the model class for table "religion".
 *
 * @property integer $id
 * @property string $title
 *
 * @property PersonDetail[] $personDetails
 */
class Religion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'religion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/person', 'ID'),
            'title' => Yii::t('andahrm/person', 'Title Religion'),
            'count_person' => Yii::t('andahrm/person', 'Count Person'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonDetails()
    {
        return $this->hasMany(Detail::className(), ['religion_id' => 'id'])
        ->joinWith('person')->where('person.deleted_at IS NULL');
    }
    
    public $count_person = 0;
    
    // public function getCount_person(){
    //     return count($this->personDetails);
    // }
}
