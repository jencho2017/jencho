<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/6
 * Time: 11:16
 */

namespace backend\controllers;


use backend\filter\accessFilter;
use backend\models\Menus;
use yii\web\Controller;

class MenusController extends Controller
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
    /**
     * 菜单列表
     */
    public function actionIndex()
    {
        $models = Menus::getList();
        return $this->render('index',['models'=>$models]);
    }
    /**
     * 菜单添加
     */
    public function actionAdd()
    {
        $model = new Menus();
        //接收数据
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','添加菜单成功');
            return $this->redirect(['menus/index']);
        }
        return $this->render('add',['model'=>$model]);
    }

    public function actionEdit($id)
    {
        $model = Menus::findOne($id);
        //接收数据
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','更新菜单成功');
            return $this->redirect(['menus/index']);
        }
        return $this->render('add',['model'=>$model]);
    }

    /**
     * 删除菜单
     */
    public function actionDelete($id)
    {
        $model = Menus::findOne(['id'=>$id]);
        $model->delete();
        \Yii::$app->session->setFlash('删除成功','success');
        return $this->redirect(['menus/index']);
    }
}