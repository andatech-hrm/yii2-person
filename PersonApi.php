<?php
namespace andahrm\person;

use andahrm\person\models\Person;
use andahrm\person\api\Model;
use andahrm\person\api\Models;

class PersonApi extends \yii\base\Object
{
    public static function instance($id)
    {
        $model = Person::findOne($id);
        return new Model(['_model' => $model]);
    }
    
    public static function instances()
    {
        return new Models();
    }
}

