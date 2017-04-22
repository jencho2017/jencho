<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/29
 * Time: 14:14
 */

namespace backend\models;


use yii\db\ActiveRecord;

class Posts_content extends ActiveRecord
{
    public function rules()
    {
        return [
          ['content','required']
        ];
    }
}