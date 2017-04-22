<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/1
 * Time: 20:45
 */

namespace backend\controllers;


use backend\filter\accessFilter;
use backend\models\Goods;
use backend\models\GoodsGallery;
use xj\uploadify\UploadAction;
use yii\web\Controller;

class GoodsGalleryController extends Controller
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

    }

    public function actionAdd($id)
    {
        //商品相册
//        $a = Goods::findOne(['id'=>$id]);
        $model=new GoodsGallery();
        if($model->load(\Yii::$app->request->post())){
            //得到拼接的字符串
            $imgs=\Yii::$app->request->post()["GoodsGallery"]["getImgs"];
            //将字符串转换成数组
            $imgs=explode(',',$imgs);
            foreach($imgs as $img){
                $_model=clone $model;
                $_model->goods_id=$id;
                $_model->path=$img;
                if($_model->validate()){
                    $_model->save();
                }
            }
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['brand/index']);
        }
        return $this->render('add',['model'=>$model]);
    }

    public function actionShow($id)
    {
        $goods = GoodsGallery::find()->where(['goods_id'=>$id])->all();
        return $this->render('show',['goods'=>$goods]);
    }

    public function actionDel($id){
        $model=GoodsGallery::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['goods-gallery/show?id='.$model->goods_id]);
    }

    //上传插件

    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload/goods',
                'baseUrl' => '@web/upload/goods',
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
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ]
        ];
    }
}