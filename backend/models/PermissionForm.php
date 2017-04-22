<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/5
 * Time: 14:35
 */

namespace backend\models;
/**
 *  权限表单模型
 */

use yii\base\Model;

class PermissionForm extends Model
{
    //定义表单属性
    public $name;
    public $description;

    public function rules()
    {
        return [
          [['name','description'],'required'],
            ['name','validateName'],
        ];
    }

    public function attributeLabels()
    {
        return [
          'name'=>'名称(路由)',
          'description'=>'描述'
        ];
    }

    public function validateName($attribute)
    {
        //实例化
        $authManager = \Yii::$app->authManager;
        if($authManager->getPermission($this->$attribute)){
            $this->addError($attribute,'权限已存在');
        }
    }
}