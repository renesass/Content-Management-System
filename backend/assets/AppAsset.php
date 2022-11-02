<?php

namespace backend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/ui.css',
    ];
    public $js = [
	    'js/site.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
		'rs\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    
    public $publishOptions = [
        'forceCopy' => true,
    ];
}
