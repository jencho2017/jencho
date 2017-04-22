<?php

namespace backend\controllers;

use backend\filter\accessFilter;
use backend\models\GoodsCategory;
use yii\helpers\Json;

class GoodsCategoryController extends \yii\web\Controller
{
    /**
     * ACF配合rbac权限控制
     */
//    public function behaviors()
//    {
//        return [
//            'accessFilter'=>[
//                'class'=>accessFilter::className(),
//            ]
//        ];
//    }
    public function actionIndex()
    {
        $models = GoodsCategory::find()->orderBy(['tree'=>SORT_ASC,'lft'=>SORT_ASC])->all();
        return $this->render('index',['models'=>$models]);
    }

    /**
     * 测试ztree插件
     */
    public function actionTest()
    {
//        $this->layout = false;//不加载布局 两种写法
        return $this->renderPartial('test');
    }
    
    //添加分类
    public function actionTest2()
    {
        $cate = new GoodsCategory(['name'=>'家用电器']);
        $cate->parent_id=0;
        $cate->makeRoot();
        $cate1 = new GoodsCategory(['name' => '电视']);
        $cate1->parent_id=1;
        $cate2 = new GoodsCategory(['name' => '冰箱']);
        $cate2->parent_id=1;
        $cate1->prependTo($cate);
        $cate2->prependTo($cate);
    }
    //商品分类添加
    public function actionAdd()
    {
        $model = new GoodsCategory();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            if($model->parent_id==0){
                $model->makeRoot();
            }else{
                $parent_cate = GoodsCategory::findOne(['id'=>$model->parent_id]);
                $model->prependTo($parent_cate);
            }
            \Yii::$app->session->setFlash('success','添加分类成功');
            return $this->redirect(['goods-category/index']);
        }
        $models = GoodsCategory::find()->asArray()->all();
        $models[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $models = Json::encode($models);
        return $this->render('add',['model'=>$model,'models'=>$models]);
    }
    //商品分类的修改
    public function actionEdit($id)
    {
        $model = GoodsCategory::findOne(['id'=>$id]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            try{
                if($model->parent_id == 0){
                    $model->makeRoot();//创建一级分类

                }else{
                    //创建非一级分类
                    //1 查找父分类
                    $parent_cate = GoodsCategory::findOne(['id'=>$model->parent_id]);
                    $model->prependTo($parent_cate);
                    \Yii::$app->session->setFlash('success','分类修改成功');
                    return $this->redirect(['goods-category/index']);//刷新本页(跳转到当前页)
                }
            }catch(Exception $e){
                \Yii::$app->session->setFlash('danger',$e->getMessage());
                $model->addError('parent_id',$e->getMessage());
            }
            //exit;

        }
        $models = GoodsCategory::find()->asArray()->all();
        $models[] = ['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $models = Json::encode($models);
        return $this->render('add',['model'=>$model,'models'=>$models]);
    }
    //删除商品分类
    public function actionDelete($id)
    {
        //根据id找到数据
        $data = GoodsCategory::findOne(['id'=>$id]);
        $data_son = GoodsCategory::findOne(['parent_id'=>$id]);
        if($data_son){
            \Yii::$app->session->setFlash('danger','不能删除有子分类的分类');
        }else{
            \Yii::$app->session->setFlash('success','删除分类成功');
            $data->delete();
        }
        $this->redirect(['goods-category/index']);
    }
}
