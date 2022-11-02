<?php
	
namespace common\assets;

use yii\web\AssetBundle;

class ExternalAsset extends AssetBundle
{
    public $sourcePath = '@common/web';
    public $css = [
        'css/external.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'rs\bootstrap\BootstrapAsset',
    ];
    
    public $publishOptions = [
        'forceCopy' => true,
    ];
}
