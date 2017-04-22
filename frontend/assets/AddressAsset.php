<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/9
 * Time: 19:35
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class AddressAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/home.css',
        'style/address.css',
        'style/goods.css',
        'style/bottomnav.css',
        'style/footer.css',
        'style/index.css',
        'style/success.css',
        'style/common.css',
        'style/jqzoom.css',
        'style/fillin.css',
        'style/list.css',
        'style/cart.css',
    ];
    public $js = [
        'js/jquery-1.8.3.min.js',
        'js/jsAddress.js',
        'js/header.js',
        'js/home.js',
        'js/goods.js',
        'js/index.js',
        'js/jqzoom-core.js',
        'js/list.js',
        'js/cart1.js',
        'js/cart2.js',


    ];
    public $depends = [
        //JqueryAsset::className(),
        'yii\web\JqueryAsset',
//        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];
}