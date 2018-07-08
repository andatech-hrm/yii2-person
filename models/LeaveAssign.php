<?php

namespace andahrm\person\models;

use Yii;
use yii\base\Model;

use andahrm\leave\models\LeavePermission;
use andahrm\leave\models\LeaveRelatedPerson;



class LeaveAssign extends Model
{
   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['leave_related_id','year','number_day'], 'required'],
            //[['user_id', 'leave_related_id'], 'integer'],
        ];
    }
    
    public $leave_related_id;
    public $year;
    public $number_day;
    public $leave_condition_id;
    public $user_id;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           // 'user_id' => Yii::t('andahrm/leave', 'Sender'),
            'leave_related_id' => Yii::t('andahrm/leave', 'Related'),
            'year' => Yii::t('andahrm/leave', 'Year'),
            'number_day' => Yii::t('andahrm/leave', 'Number Day'),
            'leave_condition_id' => Yii::t('andahrm/leave', 'Leave Condition'),
        ];
    }


    public function save(){
        
        $modelRelated = new LeaveRelatedPerson();
        $modelRelated->user_id = $this->user_id;
        $modelRelated->leave_related_id = $this->leave_related_id;
        if(!$modelRelated->save(false)) return $modelRelated;
        
        $modelPermission = new LeavePermission();
        $modelPermission->user_id = $this->user_id;
        $modelPermission->year = $this->year;
        $modelPermission->number_day = $this->number_day;
        $modelPermission->leave_condition_id = 1;
        if(!$modelPermission->save(false)) return $modelRelated;
        
        return true;
        
    }
  
}
