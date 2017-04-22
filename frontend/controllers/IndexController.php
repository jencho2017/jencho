<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 10:24
 */

namespace frontend\controllers;


use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\GoodsCategory;
use yii\web\Controller;
use yii\web\Cookie;

class IndexController extends Controller
{
    public $layout = 'address';
    /**
     * 商品分类
     */
    public function actionIndex()
    {
        return $this->render('index');
    }



}