<?php

namespace andahrm\person\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class PrintAsset extends AssetBundle
{
    // public $basePath = '@webroot';
    // public $baseUrl = '@web';
    public $sourcePath = '@andahrm/person/assets';
    public $css = [
        'css/print.css',
    ];
    public $js = [
    ];
}
