<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menus".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $url
 * @property string $description
 */
class Menus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parent_id'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['url', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '菜单名',
            'parent_id' => '上级分类',
            'url' => '路由',
            'description' => '描述',
        ];
    }

    public function getChildren()
    {
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }

    public static function getMenus()
    {
        $menus = Menus::find()->where(['parent_id'=>0])->asArray()->all();
        return ArrayHelper::map($menus,'id','name');
    }

    public static function getList()
    {
        $menus = [];
        $parents = Menus::find()->where(['parent_id'=>0])->all();
        foreach($parents as $parent){
            $menus[] = $parent;
            foreach($parent->children as $child){
                $child->name = '－－'.$child->name;
                $menus[] = $child;
            }
        }
        return $menus;
    }
}
