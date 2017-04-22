<?php
namespace backend\filter;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use yii\web\HttpException;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/8
 * Time: 9:56
 */
class accessFilter extends \yii\base\ActionFilter
{
    public function beforeAction($actions)
    {
        //判断当前用户的权限
        if(!\Yii::$app->user->can($actions->uniqueId)){
//            $actions->uniqueId;exit;
            if(\Yii::$app->user->isGuest){
                return $actions->controller->redirect(\Yii::$app->user->loginUrl);
            }
            throw new HttpException(403,'你没有该操作权限');
            return false;
        }
        return parent::beforeAction($actions);
    }
}