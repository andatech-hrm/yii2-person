<?php

namespace andahrm\person\models;

use Yii;

/**
 * This is the model class for table "person_title".
 *
 * @property integer $id
 * @property string $name
 * @property string $initial
 */
class Title extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_title';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'initial'], 'required'],
            [['name', 'initial'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/person', 'ID'),
            'name' => Yii::t('andahrm/person', 'Name'),
            'initial' => Yii::t('andahrm/person', 'ชื่อย่อ'),
        ];
    }
}
