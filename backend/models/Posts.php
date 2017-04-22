<?php

namespace app\models;

use backend\models\Category;
use backend\models\Posts_content;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property string $author
 * @property integer $cate_id
 * @property integer $is_valid
 * @property integer $create_at
 * @property integer $update_at
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $content;
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'author', 'cate_id' ,'content'], 'required'],
            [['cate_id', 'is_valid', 'create_at', 'update_at'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['author'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '文章标题',
            'author' => '作者',
            'cate_id' => '分类id',
            'is_valid' => '文章状态',
            'create_at' => '创建时间',
            'update_at' => '修改时间',
            'content'=>'内容',
        ];
    }
    //一对一拿到文章内容
    public function getContent()
    {
        return $this->hasOne(Posts_content::className(),['post_id'=>'id']);
    }
    //拿到分类数据
    public static function getCateOptions()
    {
        $cates = Category::find()->asArray()->all();
        return ArrayHelper::map($cates,'id','name');
    }
    //拿到分类
    public function getCategory()
    {
        return $this->hasOne(Category::className(),['id'=>'cate_id']);
    }
}
