<?php

namespace andahrm\person\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use andahrm\datepicker\behaviors\DateBuddhistBehavior;
use andahrm\person\models\Person;
use andahrm\structure\models\Position;

/**
 * This is the model class for table "person_retired".
 *
 * @property int $user_id
 * @property int $last_position_id
 * @property string $retired_date
 * @property int $because
 * @property string $note
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class PersonRetired extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'person_retired';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'retired_date'], 'required'],
            [['user_id', 'last_position_id', 'because', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['retired_date'], 'safe'],
            [['note'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    function behaviors() {
        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'retired_date',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => Yii::t('andahrm/person', 'Fullname'),
            'last_position_id' => Yii::t('andahrm/person', 'Last Position ID'),
            'retired_date' => Yii::t('andahrm/person', 'Retired Date'),
            'because' => Yii::t('andahrm/person', 'Because'),
            'note' => Yii::t('andahrm/person', 'Note'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
        ];
    }

    public function getUser() {
        return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
    }

    public function getLastPosition() {
        return $this->hasOne(Position::className(), ['id' => 'last_position_id']);
    }

    const BECAUSE_MOVE_OUT = '1';
    const BECAUSE_RETIRED = '2';
    const BECAUSE_NO_CONTRACT = '3';
    const BECAUSE_RESIGN = '4';
    const BECAUSE_DIE = '5';

    public static function itemsAlias($key) {
        $items = [
            'because' => [
                self::BECAUSE_MOVE_OUT => Yii::t('andahrm/person', 'Move Out'),
                self::BECAUSE_RETIRED => Yii::t('andahrm/person', 'Retired'),
                self::BECAUSE_NO_CONTRACT => Yii::t('andahrm/person', 'Did not renew the contract'),
                self::BECAUSE_RESIGN => Yii::t('andahrm/person', 'Resign'),
                self::BECAUSE_DIE => Yii::t('andahrm/person', 'Die'),
            ],
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public function getBecauseLabel() {
        return ArrayHelper::getValue($this->getItemBecause(), $this->because);
    }

    public static function getItemBecause() {
        return self::itemsAlias('because');
    }

    public function getPosition() {
        return $this->hasOne(Position::className(), ['id' => 'last_position_id']);
    }

}
