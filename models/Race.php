<?php

namespace andahrm\person\models;

use Yii;

/**
 * This is the model class for table "race".
 *
 * @property integer $id
 * @property string $title
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property PersonDetail[] $personDetails
 */
class Race extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'race';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/person', 'ID'),
            'title' => Yii::t('andahrm/person', 'เชื้อชาติ'),
            'created_at' => Yii::t('andahrm/person', 'Created At'),
            'created_by' => Yii::t('andahrm/person', 'Created By'),
            'updated_at' => Yii::t('andahrm/person', 'Updated At'),
            'updated_by' => Yii::t('andahrm/person', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonDetails()
    {
        return $this->hasMany(PersonDetail::className(), ['race_id' => 'id']);
    }
}
