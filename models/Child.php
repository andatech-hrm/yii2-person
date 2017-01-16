<?php

namespace andahrm\person\models;

use Yii;

/**
 * This is the model class for table "person_child".
 *
 * @property integer $user_id
 * @property string $people_id
 * @property string $relation
 *
 * @property Person $user
 * @property People $people
 */
class Child extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_child';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'people_id', 'relation'], 'required'],
            [['user_id', 'people_id'], 'integer'],
            [['relation'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['people_id'], 'exist', 'skipOnError' => true, 'targetClass' => People::className(), 'targetAttribute' => ['people_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('andahrm/person', 'User ID'),
            'people_id' => Yii::t('andahrm/person', 'People ID'),
            'relation' => Yii::t('andahrm/person', 'Relation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasOne(People::className(), ['id' => 'people_id']);
    }
}
