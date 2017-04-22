<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/29
 * Time: 22:40
 */

namespace backend\controllers;


use backend\models\Article;
use backend\models\ArticleDetail;
use backend\filter\accessFilter;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Request;

class ArticleController extends Controller
{
    //文章列表
    public function actionIndex()
    {
        $query = Article::find();
        //总条数
        $total = $query->count();
        //每页显示条数
        $pageSize = 2;
        //当前第几页
        $pager = new Pagination([
            'totalCount'=>$total,
            'pageSize'=>$pageSize
        ]);
        //设置sql参数
        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }
    //文章添加
    public function actionAdd()
    {
        //实例化数据模型
        $model = new Article();
        //实例化文章内容数据模型
        $content = new ArticleDetail();
        //接收数据
        $request = \Yii::$app->request;
        if($request->isPost){
            //加载数据,只有rules里有的属性才能被加载
            //至少要加safe规则
            $model->load($request->post());
            $content->content = $model->content;
                if($model->validate()&&$content->validate()){
                    $model->inputtime = time();
                    $model->update_time = 0;
                    $model->save();
                    $content->article_id = $model->id;
                    $content->save();
                    \Yii::$app->session->setFlash('success','添加成功!');
                    return $this->redirect(['article/index']);
                }
            }
            //yii通过$model->isNewRecord来判断是否是个新纪录,从而进行添加或者修改
            //验证数据,只有通过rules规则的属性才能验证通过
        //添加视图
        return $this->render('add',['model'=>$model]);
    }
    //修改文章
    public function actionEdit($id)
    {
        //实例化数据模型
        $model = Article::findOne(['id'=>$id]);
        //实例化文章内容数据模型
        $content = ArticleDetail::findOne(['article_id'=>$id]);
        //接收数据
        $request = \Yii::$app->request;
        if($request->isPost){
            //加载数据,只有rules里有的属性才能被加载
            //至少要加safe规则
            $model->load($request->post());
            $content->content = $model->content;
            if($model->validate()&&$content->validate()){
                $model->update_time = time();
                $model->save();
                $content->article_id = $id;
                $content->save();
                \Yii::$app->session->setFlash('success','添加成功!');
                return $this->redirect(['article/index']);
            }
        }
        //yii通过$model->isNewRecord来判断是否是个新纪录,从而进行添加或者修改
        //验证数据,只有通过rules规则的属性才能验证通过
        //添加视图
        return $this->render('add',['model'=>$model]);
    }

    //删除文章
    public function actionDelete($id)
    {
        //根据id找到数据
        $model = Article::findOne(['id'=>$id]);
        //根据id找到文章内容
        $content = ArticleDetail::findOne(['article_id'=>$id]);
        $content->delete();
        $model->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['article/index']);
    }

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
}