<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/9
 * Time: 19:51
 */

namespace frontend\controllers;


use backend\models\Article;
use backend\models\GoodsCategory;
use frontend\models\Address;
use frontend\models\Order;
use yii\web\Controller;

class AddressController extends Controller
{
    public $layout = 'address';

    public function actionAdd()
    {
        $goodsCategorys = GoodsCategory::find()->where(['parent_id'=>0])->all();
        $articles = Article::find()->all();
        $model = new Address();
        $addresss = Address::find()->all();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->province = $_POST['province'];
            $model->city = $_POST['city'];
            $model->area = $_POST['area'];
            $model->save();
            if($model->validate()){
                if($model->status){
                    $status1 = Address::find()->where(['status'=>1])->all();

                    foreach($status1 as $status){
                        $status->status = 0;
                        $status->update();
                    }
                    $model->status = 1;
                }
                $model->user_id = \Yii::$app->user->id;
                $model->save();
                \Yii::$app->session->setFlash('success','添加地址成功');
                return $this->refresh();
            }
        }
        return $this->render('address',['model'=>$model,'addresss'=>$addresss,'goodsCategorys'=>$goodsCategorys,'articles'=>$articles]);
    }

    public function actionEdit($id)
    {
        $model = Address::findOne(['id'=>$id]);
        $addresss = Address::find()->all();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->province = $_POST['province'];
            $model->city = $_POST['city'];
            $model->area = $_POST['area'];
            $model->save();
            if($model->validate()){
                if($model->status){
                    $status1 = Address::find()->where(['status'=>1])->all();

                    foreach($status1 as $status){
                        $status->status = 0;
                        $status->update();
                    }
                    $model->status = 1;
                }
                $model->user_id = \Yii::$app->user->id;
                $model->save();
                \Yii::$app->session->setFlash('success','添加地址成功');
                return $this->refresh();
            }
        }
        return $this->render('address',['model'=>$model,'addresss'=>$addresss]);
    }

    public function actionDelete($id)
    {
        $model = Address::findOne(['id'=>$id]);
        $model->delete();
        \Yii::$app->session->setFlash('success','删除地址成功');
        return $this->redirect(['address/add']);
    }

    public function actionCheck($id)
    {
        $model = Address::findOne(['id'=>$id]);
        $status1 = Address::find()->where(['status'=>1])->all();

        foreach($status1 as $status){
            $status->status = 0;
            $status->update();
        }
        $model->status = 1;
        $model->save();
        \Yii::$app->session->setFlash('success','设置默认地址成功');
        return $this->redirect(['address/add']);
    }

    public function actionIndex()
    {
        $goodsCategorys = GoodsCategory::find()->where(['parent_id'=>0])->all();
        $articles = Article::find()->all();
        return $this->render('address',['goodsCategorys'=>$goodsCategorys,'articles'=>$articles]);
    }
}