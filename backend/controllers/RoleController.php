<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/5
 * Time: 15:38
 */

namespace backend\controllers;


use backend\filter\accessFilter;
use backend\models\RoleForm;
use yii\web\Controller;

class RoleController extends Controller
{
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
    public function actionIndex()
    {
        $authManager = \Yii::$app->authManager;
        $roles = $authManager->getRoles();
        return $this->render('index',['roles'=>$roles]);
    }

    public function actionAdd()
    {
        $model = new RoleForm();
        $model->scenario = RoleForm::SCENARIO_ADD;
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $authManager = \Yii::$app->authManager;
            $role = $authManager->createRole($model->name);
            $role->description = $model->description;
            $authManager->add($role);
            foreach($model->permissions as $permission){
                $authManager->addChild($role,$authManager->getPermission($permission));
            }
            \Yii::$app->session->setFlash('success',$model->name.'角色添加成功');
            return $this->redirect(['role/index']);
        }
        return $this->render('add',['model'=>$model]);
    }
    
    /**
     * 角色的修改
     */
    public function actionEdit($name)
    {
        //拿到角色信息
        $model = new RoleForm();
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getRole($name);
        $model->name = $role->name;
        $model->description = $role->description;
        $permission = $authManager->getPermissionsByRole($role->name);
        $model->permissions = array_keys($permission);

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $authManager = \Yii::$app->authManager;
            $role->description = $model->description;
            $authManager->update($role->name,$role);
            $authManager->removeChildren($role);
            foreach($model->permissions as $permission){
                $authManager->addChild($role,$authManager->getPermission($permission));
            }
            \Yii::$app->session->setFlash('success',$model->name.'角色修改成功');
            return $this->redirect(['role/index']);
        }

        return $this->render('add',['model'=>$model]);
    }

    public function actionDelete($name)
    {
        $authManager = \Yii::$app->authManager;
        $authManager->remove($authManager->getRole($name));
        \Yii::$app->session->setFlash('success',$name.'角色修改成功');
        return $this->redirect(['role/index']);
    }
}