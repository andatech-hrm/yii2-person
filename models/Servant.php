<?php

namespace andahrm\person\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use andahrm\datepicker\behaviors\YearBuddhistBehavior;

/**
 * This is the model class for table "person_servant".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $start_date
 * @property string $end_date
 * @property string $work_date
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class Servant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_servant';
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
            'start_date' => [
                'class' => YearBuddhistBehavior::className(),
                'attribute' => 'start_date',
            ],
            'end_date' => [
                'class' => YearBuddhistBehavior::className(),
                'attribute' => 'end_date',
            ],
            'work_date' => [
                'class' => YearBuddhistBehavior::className(),
                'attribute' => 'work_date',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['user_id', 'start_date', 'end_date'], 'required'],
            [['user_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'work_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/person', 'ID'),
            'user_id' => Yii::t('andahrm/person', 'User ID'),
            'start_date' => Yii::t('andahrm/person', 'Start Date'),
            'end_date' => Yii::t('andahrm/person', 'End Date'),
            'work_date' => Yii::t('andahrm/person', 'Work Date'),
            'created_at' => Yii::t('andahrm/person', 'Created At'),
            'created_by' => Yii::t('andahrm/person', 'Created By'),
            'updated_at' => Yii::t('andahrm/person', 'Updated At'),
            'updated_by' => Yii::t('andahrm/person', 'Updated By'),
        ];
    }
}
