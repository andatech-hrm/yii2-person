<?php

namespace andahrm\person\models;

use Yii;

/**
 * This is the model class for table "people".
 *
 * @property integer $id
 * @property string $citizen_id
 * @property string $name
 * @property string $surname
 * @property string $birthday
 * @property integer $nationality_id
 * @property integer $race_id
 * @property string $occupation
 * @property string $live_status
 */
class PeopleMother extends People
{
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->type = parent::TYPE_MOTHER;
            return true;
        } else {
            return false;
        }
    }
}
