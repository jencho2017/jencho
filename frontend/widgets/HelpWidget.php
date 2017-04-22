<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 23:06
 */

namespace frontend\widgets;


use backend\models\Article;
use backend\models\ArticleCategory;
use yii\base\Widget;

class HelpWidget extends Widget
{
    public function run()
    {
        $html = '';
        $categorys = ArticleCategory::find()->where(['is_help'=>1])->all();
        $n = 1;
        foreach($categorys as $category){
            $html .= '<div class="bnav'.$n.'">
			<h3><b></b> <em>'.$category->name.'</em></h3>
			<ul>';
            $articles = Article::find()->where(['article_category_id'=>$category->id])->all();
            foreach($articles as $article){
                $html .= '<li>'.$article->name.'</li>';
            }
            $html .= '</ul>
	    </div>';
            $n++;
        }

        return $html;
    }
}