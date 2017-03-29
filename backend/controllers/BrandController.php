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

use xj\uploadify\UploadAction;
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

//            $model->logo_file = UploadedFile::getInstance($model,'logo_file');
            if($model->validate()){
//                if($model->logo_file){
//                    $fileName = 'upload/brand'.uniqid().'.'.$model->logo_file->extension;
//                    if($model->logo_file->saveAs($fileName,false)){
//                        $model->logo = $fileName;
//                    }
//                }
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
//                if($model->logo_file){
//                    $fileName = 'upload/brand'.uniqid().'.'.$model->logo_file->extension;
//                    if($model->logo_file->saveAs($fileName,false)){
//                        $model->logo = $fileName;
//                    }
//                }
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

    //上传插件

    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload/brand',
                'baseUrl' => '@web/upload/brand',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                //'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
//                'format' => function (UploadAction $action) {
//                    $fileext = $action->uploadfile->getExtension();
//                    $filename = sha1_file($action->uploadfile->tempName);
//                    return "{$filename}.{$fileext}";
//                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png','gif'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();
                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
        ];
    }
}