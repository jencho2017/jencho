<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property integer $is_help
 */
class ArticleCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'],'unique'],
            [['intro'], 'string'],
            [['status', 'sort', 'is_help'], 'integer'],
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
            'name' => '��������',
            'intro' => '������',
            'status' => '����״̬',
            'sort' => '��������',
            'is_help' => '�Ƿ�Ϊ������صķ���',
        ];
    }
}
