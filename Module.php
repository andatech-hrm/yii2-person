<?php

namespace andahrm\person;

/**
 * person module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'andahrm\person\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->layoutPath = '@app/views/layouts';
        parent::init();

        // custom initialization code goes here
    }
}
