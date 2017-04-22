<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/29
 * Time: 11:52
 */

namespace backend\controllers;
/**
 * 文章控制器
 */

use app\models\Posts;
use backend\models\Posts_content;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class PostsController extends Controller
{
    //文章列表页
    public function actionIndex()
    {
        $query = Posts::find();
        //总条数
        $total = $query->count();
        //每页显示多少条
        $pageSize = 3;
        //当前第几页
        $pager = new Pagination([
            'totalCount'=>$total,
            'pageSize'=>$pageSize,
        ]);
        //设置sql参数
        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }
    //文章添加
    public function actionAdd()
    {
        //实例化数据模型
        $model = new Posts();
        $content = new Posts_content();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            //暂不考虑图片
            if($model->validate()){
                $model->create_at = time();
                $model->update_at = 0;
                $model->save();
                $id = \Yii::$app->db->getLastInsertID();
                $content->posts_id = $id;
                $content->content = $model->content;
                $content->save();
                \Yii::$app->session->setFlash('success','添加成功!');
                return $this->redirect(['posts/index']);
            }
        }
        //显示添加页面
        return $this->render('add',['model'=>$model]);
    }
//    public function actionAdd()
//    {
//        //实例化文章模型和文章内容模型
//        $posts = new Posts();
//        $content = new Posts_content();
//        //接收并验证
//        $request = new Request();
//        if($request->isPost){
//            $posts->load($request->post());
//            $content->load($request->post());
//            if($posts->validate() && $content->validate()){
//                $posts->save();
//                $content->posts_id = $posts->id;
//                $content->save();
//            }
//        }
//
//        return $this->render('add',['model'=>$posts]);
//    }
    //删除
    public function actionDelete($id)
    {
        //根据id找到数据
        $model = Posts::findOne(['id'=>$id]);
        //根据id找到文章内容
        $content = Posts_content::findOne(['posts_id'=>$id]);
        $content->delete();
        $model->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['posts/index']);
    }
    //修改
    public function actionEdit($id)
    {
        //根据id找到数据
        $model = Posts::findOne(['id'=>$id]);
        //根据id找到文章内容
        $content = Posts_content::findOne(['posts_id'=>$id]);
        $model->content = $content->content;

        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->update_at = time();
                $model->save();
                $content->posts_id = $id;
                $content->content = $model->content;
                $content->save();
                \Yii::$app->session->setFlash('success','修改成功!');
                return $this->redirect(['posts/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }

}