<?php

namespace andahrm\person\models;

use Yii;
use yii\db\ActiveRecord;
use andahrm\setting\models\Helper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use andahrm\datepicker\behaviors\YearBuddhistBehavior;
// use karpoff\icrop\CropImageUploadBehavior;
use anda\core\widgets\cropimageupload\CropImageUploadBehavior;
/**
 * This is the model class for table "person_photo".
 *
 * @property integer $user_id
 * @property string $year
 * @property string $image
 * @property string $image_original
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class Photo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_photo';
    }
    
    function behaviors()
    {
        if(!is_dir(Yii::getAlias('@uploads/person'))){
            \yii\helpers\FileHelper::createDirectory(Yii::getAlias('@uploads/person'));
        }
        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
            'image' => [
                'class' => CropImageUploadBehavior::className(),
                'attribute' => 'image',
                'scenarios' => ['insert', 'update'],
                'path' => '@uploads/person/{user_id}',
                'url' => '/uploads/person/{user_id}',
                'ratio' => 1,
                'resize' => [512],
                'crop_field' => 'image_crop',
                'cropped_field' => 'image_cropped',
            ],
            // 'year' =>[
            //     'class' => AttributeBehavior::className(),
            //     'attributes' => [
            //         ActiveRecord::EVENT_BEFORE_INSERT => 'year',
            //         ActiveRecord::EVENT_BEFORE_UPDATE => 'year',
            //     ],
            //     'value' => function($event) {
            //         return intval($this->year) - Helper::YEAR_TH_ADD;
            //     },
            // ],
            'year' => [
                'class' => YearBuddhistBehavior::className(),
                'attribute' => 'year',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'image'], 'required'],
            [['user_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['year', 'image_crop', 'image_cropped'], 'safe'],
//             [['image', 'image_original'], 'string', 'max' => 255],
            ['image', 'file', 'extensions' => 'jpg, jpeg, gif, png', 'on' => ['insert', 'update']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('andahrm/person', 'User'),
            'year' => Yii::t('andahrm/person', 'Year'),
            'image' => Yii::t('andahrm/person', 'Image'),
            'image_original' => Yii::t('andahrm/person', 'Original Image'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
        ];
    }
    
    
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            
            return true;
        } else {
            return false;
        }
    }
    
    
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
    }
    
    public function getYearBuddhist()
    {
        $yearDistance = $this->getBehavior('year')->yearDistance;
        return (intval($this->year) + $yearDistance);
    }
}
