<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 15:39
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class ShouyeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/index.css',
        'style/bottomnav.css',
        'style/footer.css',
    ];
    public $js = [
        'js/header.js',
        'js/index.js'
    ];
    public $depends = [
        //JqueryAsset::className(),
        'yii\web\JqueryAsset',
//        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}