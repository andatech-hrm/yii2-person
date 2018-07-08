<?php

namespace andahrm\person;

/**
 * person module definition class
 */
class Module extends \yii\base\Module
{
    //public $layout = '@andahrm/person/views/layouts/main';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'andahrm\person\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
//         $this->layout = '@andahrm/person/views/layouts/main';
        parent::init();

        // custom initialization code goes here
    }
}
