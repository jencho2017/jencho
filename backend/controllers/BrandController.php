<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/28
 * Time: 13:31
 */

namespace backend\controllers;
/**
 * 品牌控制器
 */

use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends Controller
{

    //品牌列表
    public function actionIndex()
    {
        $query = Brand::find()->where(['status'=>['0','1']]);
        $pager = new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>2,
        ]);
        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }
    //回收站
    public function actionSave_delete_index()
    {
        $query = Brand::find()->where(['status'=>'-1']);
        $pager = new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>2,
        ]);
        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('save',['models'=>$models,'pager'=>$pager]);
    }
    //品牌添加
    public function actionAdd()
    {
        //实例化品牌模型
        $model = new Brand();
        //接收表单数据
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());

            $model->logo_file = UploadedFile::getInstance($model,'logo_file');
            if($model->validate()){
                if($model->logo_file){
                    $fileName = 'upload/brand'.uniqid().'.'.$model->logo_file->extension;
                    if($model->logo_file->saveAs($fileName,false)){
                        $model->logo = $fileName;
                    }
                }
                $model->save();
                \Yii::$app->session->setFlash('success','添加品牌成功!');
                return $this->redirect(['brand/index']);
            }
        }
        //显示添加品牌页
        return $this->render('add',['model'=>$model]);
    }
    //修改
    public function actionEdit($id)
    {
        $model = Brand::findOne(['id'=>$id]);
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            $model->logo_file = UploadedFile::getInstance($model,'logo_file');
            if($model->validate()){
                if($model->logo_file){
                    $fileName = 'upload/brand'.uniqid().'.'.$model->logo_file->extension;
                    if($model->logo_file->saveAs($fileName,false)){
                        $model->logo = $fileName;
                    }
                }
                $model->save();
                \Yii::$app->session->setFlash('success','修改成功!');
                return $this->redirect(['brand/index']);
            }
        }

        //显示修改界面
        return $this->render('add',['model'=>$model]);
    }

    //保存删除
    public function actionSave_delete($id)
    {
        $model = Brand::findOne(['id'=>$id]);
        $model->status = -1;
        $model->save();
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['brand/index']);
    }
    //删除
    public function actionDelete($id)
    {
        $model = Brand::findOne(['id'=>$id]);
        $model->delete();
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['brand/index']);
    }
}