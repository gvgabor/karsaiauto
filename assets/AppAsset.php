<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $jsOptions = ["position" => View::POS_HEAD];
    public $basePath  = '@webroot';
    public $baseUrl   = '@web';



    public $css = [
        'css/fontawesome.min.css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        'kendo/styles/kendo.common-bootstrap.min.css',
        'kendo/styles/kendo.bootstrap-main.min.css',
        'kendo/styles/bootstrap-4.css',
        'css/main.css',
    ];

    public $js = [
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        'https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js',
        "kendo/js/kendo.all.min.js",
        "kendo/js/cultures/kendo.culture.hu.min.js",
        "kendo/js/cultures/kendo.culture.hu-HU.min.js",
        "kendo/js/messages/kendo.messages.hu-HU.min.js",
    ];


    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
