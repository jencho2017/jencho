<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 23:45
 */

namespace frontend\widgets;


use backend\models\GoodsCategory;
use yii\base\Widget;

class GoodsDetailWidget extends Widget
{
    public function run()
    {
        $html = '<div class="breadcrumb">';
        $goodsCates = GoodsCategory::findOne(['id'=>7]);
        $a = GoodsCategory::findOne(['id'=>$goodsCates->parent_id]);
        //如果传来id有父级,
        if($a){
            $b = GoodsCategory::findOne(['id'=>$a->parent_id]);
            if($b){
                $c = GoodsCategory::findOne([['id'=>$b->parent_id]]);
                if($c){}else{
                    $html .= '<h2>当前位置：<a href="">首页</a> > <a href="">'.$b->name.' > '.$a->name.' > '.$goodsCates->name.'</a></h2>
    </div>
    <div class="list_left fl mt10">';
                }
            }else{
                $html .= '<h2>当前位置：<a href="">首页</a> > <a href="">'.$a->name.' > '.$goodsCates->name.'</a></h2>
    </div>
    <div class="list_left fl mt10">';
            }
        }else{
            $html .= '<h2>当前位置：<a href="">首页</a> > <a href="">'.$goodsCates->name.'</a></h2>
    </div>
    <div class="list_left fl mt10">';
        }

        $html .= '<div class="catlist">
            <h2>'.$goodsCates->name.'</h2>
            <div class="catlist_wrap">';
        $goodsCatess = GoodsCategory::find()->where(['parent_id'=>$goodsCates->id])->all();
        foreach($goodsCatess as $goodsCatesss){
            $html .= '<div class="child">
                    <h3><b></b>'.$goodsCatesss->name.'</h3>
                    <ul class="on">';
            $goodsCatessss = GoodsCategory::find()->where(['parent_id'=>$goodsCatesss->id])->all();
            foreach($goodsCatessss as $goodsCatesssss){
                $html .= '<li>'.$goodsCatesssss->name.'</li>';
            }
            $html .= '</ul>
                </div>';
        }
        $html .= '</div>

            <div style="clear:both; height:1px;"></div>
        </div>';

        $h = <<<EOT
        <!-- 面包屑导航 start -->
    <div class="breadcrumb">
        <h2>当前位置：<a href="">首页</a> > <a href="">电脑、办公</a></h2>
    </div>
    <!-- 面包屑导航 end -->

    <!-- 左侧内容 start -->
    <div class="list_left fl mt10">

EOT;

        return $html;
    }
}