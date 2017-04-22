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
use yii\helpers\ArrayHelper;

class RoleForm extends Model
{
    //定义表单属性
    public $name;
    public $description;
    public $permissions=[];
    const SCENARIO_ADD ='add';
    public function rules()
    {
        return [
          [['name','description'],'required'],
            ['name','validateName','on'=>self::SCENARIO_ADD],
            ['permissions','safe']
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        return ArrayHelper::merge($scenarios,[self::SCENARIO_ADD=>['name','description','permissions']]);
    }

    public function attributeLabels()
    {
        return [
          'name'=>'角色名称',
          'description'=>'描述',
            'permissions'=>'分配权限'
        ];
    }

    public function validateName($attribute)
    {
        //实例化
        $authManager = \Yii::$app->authManager;
        if($authManager->getRole($this->$attribute)){
            $this->addError($attribute,'角色已存在');
        }
    }

    public static function getPermissions()
    {
        $authManager = \Yii::$app->authManager;
        $permissions = $authManager->getPermissions();
        return ArrayHelper::map($permissions,'name','description');
    }
}