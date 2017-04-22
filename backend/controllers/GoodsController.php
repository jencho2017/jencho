<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/1
 * Time: 0:44
 */

namespace backend\controllers;


use backend\filter\accessFilter;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use xj\uploadify\UploadAction;
use yii\helpers\Json;
use yii\web\Controller;

class GoodsController extends Controller
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
    //商品列表
    public function actionIndex()
    {
        $models = Goods::find()->all();
        return $this->render('index',['models'=>$models]);
    }
    //商品添加
    public function actionAdd()
    {
        $model = new Goods();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $intro = new GoodsIntro();
            $intro->content = $model->content;
            if($model->validate() && $intro->validate()){
                //生成货号
                $sum = $model->status;
                //添加时间
                $model->inputtime = time();
                $model->status = array_sum($sum);
                $goods_day_count = new GoodsDayCount();
                //判断day 如果day不存在就创建day 如果存在就在count里加1
                $day = date('Y-m-d');
                $r = GoodsDayCount::findOne(['day'=>$day]);
//                var_dump($r);exit;
                if($r == null){
                    $r = new GoodsDayCount();
                    $r->day = $day;
                    $r->count =0;
                    $r->save();
                }
                //生成货号
                $model->sn = date('Ymd').str_pad(++$r->count,4,0,STR_PAD_LEFT);
//                var_dump($model->sn);exit;
                $model->save();
                //商品详情id
                $intro->goods_id = $model->id;
                //保存商品详情至表
                $intro->save();
                $goods_day_count->updateAllCounters(['count'=>+1],['day'=>date('Y-m-d')]);
                \Yii::$app->session->setFlash('success','请继续添加商品相册!');
                //return $this->redirect(['goods/gallery','id'=>$model->id]);
                return $this->redirect(['goods-gallery/add','id'=>$model->id]);
            }
        }
        $models = GoodsCategory::find()->asArray()->all();
        $models[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $models = Json::encode($models);
        return $this->render('add',['model'=>$model,'models'=>$models]);
    }

    public function actionEdit($id)
    {
        $model = Goods::findOne(['id'=>$id]);
        $conten = GoodsIntro::findOne(['goods_id'=>$id]);
        $model->content = $conten->content;
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $intro = new GoodsIntro();
            $intro->content = $model->content;
            if($model->validate() && $intro->validate()){
                //生成货号
                $sum = $model->status;
                //添加时间
                $model->status = array_sum($sum);
                $day = date('Y-m-d');
                $model->save();
                //商品详情id
                //保存商品详情至表
                $intro->save();
                \Yii::$app->session->setFlash('success','修改成功!');
                return $this->redirect(['goods/index']);
            }
        }
        $models = GoodsCategory::find()->asArray()->all();
        $models[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $models = Json::encode($models);
        return $this->render('add',['model'=>$model,'models'=>$models]);
    }

    public function actionDelete($id)
    {
        $goods = Goods::findOne(['id'=>$id]);
        $intro = GoodsIntro::findOne(['goods_id'=>$id]);
        $goods->delete();
        $intro->delete();
        \Yii::$app->session->setFlash('success','删除成功!');
        return $this->redirect(['goods/index']);
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