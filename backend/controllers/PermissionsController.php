<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/5
 * Time: 14:43
 */

namespace backend\controllers;


use backend\models\PermissionForm;
use yii\web\Controller;
use yii\web\Request;

class PermissionsController extends Controller
{
    public function actionIndex()
    {

        $authManager = \Yii::$app->authManager;
        $permissions = $authManager->getPermissions();
        return $this->render('index',['permissions'=>$permissions]);
    }

    public function actionAdd()
    {
        $model = new PermissionForm();
        //接收表单传来数据
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //实例化
            $authManager = \Yii::$app->authManager;
            $permission = $authManager->createPermission($model->name);
            $permission->description = $model->description;
            if($authManager->add($permission)){
                \Yii::$app->session->setFlash('success','新增权限成功!');
                return $this->redirect(['permissions/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    /**
     * 删除权限
     */
    public function actionDelete($name)
    {
        $authManager = \Yii::$app->authManager;
        $permission = $authManager->getPermission($name);
        $authManager->remove($permission);
        \Yii::$app->session->setFlash('success','删除权限成功!');
        return $this->redirect(['permissions/index']);
    }
}