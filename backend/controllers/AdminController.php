<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/5
 * Time: 21:20
 */

namespace backend\controllers;



use backend\filter\accessFilter;
use backend\models\SignupForm;
use common\models\Admin;
use yii\filters\AccessControl;
use yii\web\Controller;

class AdminController extends Controller
{
    //管理员列表
    public function actionIndex()
    {
        $models = Admin::find()->all();

        return $this->render('index',['models'=>$models]);
    }
    //查看管理员权限
    public function actionCheck($id)
    {
        $authManager = \Yii::$app->authManager;
        $permissions = $authManager->getPermissionsByUser($id);
        $admin = Admin::findOne(['id'=>$id]);
        return $this->render('check',['permissions'=>$permissions,'admin'=>$admin]);
    }
    //删除管理员
    public function actionDelete($id)
    {
        $authManager = \Yii::$app->authManager;
        $admin = Admin::findOne(['id'=>$id]);
        $authManager->revokeAll($id);
        $admin->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['admin/index']);
    }

    /**
     * ACF配合rbac权限控制
     */
    public function behaviors()
    {
        return [
            'accessFilter'=>[
                'class'=>accessFilter::className(),
            ]
        ];
    }

}