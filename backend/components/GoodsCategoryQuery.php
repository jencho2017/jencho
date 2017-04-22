<?php
namespace backend\components;
use creocoder\nestedsets\NestedSetsQueryBehavior;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/30
 * Time: 14:33
 */
class GoodsCategoryQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}