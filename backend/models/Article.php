<?php

namespace backend\models;


use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property integer $article_category_id
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property integer $inputtime
 * @property integer $update_time
 */
class Article extends \yii\db\ActiveRecord
{
    public $content;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'article_category_id', 'intro','content'], 'required'],
            [['article_category_id', 'status', 'sort', 'inputtime', 'update_time'], 'integer'],
            [['intro'], 'string'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章名',
            'article_category_id' => '分类ID',
            'intro' => '文章简介',
            'status' => '文章状态',
            'sort' => '文章排序',
            'inputtime' => '添加时间',
            'update_time' => '最近一次修改时间',
            'content'=>'内容'
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);
    }
    //拿到分类数据
    public static function getCatrgoryOptions()
    {
        $cates = ArticleCategory::find()->asArray()->all();
        return ArrayHelper::map($cates,'id','name');
    }


}
