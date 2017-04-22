<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12
 * Time: 9:34
 */

namespace frontend\widgets;


use backend\models\Goods;
use yii\base\Widget;
use yii\helpers\Url;

class GoodsListWidget extends Widget
{
    public function run()
    {
        $html = '<div class="goodslist mt10">
            <ul>';
        $goods = Goods::find()->orderBy('id')->limit(8)->all();
        foreach($goods as $good){
            $g = \backend\models\Goods::$status_options[$good->status];
            $goodsUrl = Url::to(['goods/xiangqing','goods_id'=>$good->id]);
            $url = \Yii::$app->params['goodsPicUrl'];
            $html .= "<li>
                    <dl>
                        <dt><a href='$goodsUrl'><img src='$url/$good->logo' /></a></dt>
                        <dd>$good->name</dd>
                        <dd><strong>$good->shop_price</strong></dd>
                        <dd><em>$g</em></dd>
                    </dl>
                </li>";
        }


        $html .= '</ul>
        </div>';





        return $html;

    }
}