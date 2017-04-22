<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m170329_142729_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('分类名称'),
            'intro'=>$this->text()->comment('分类简介'),
            'status'=>$this->smallInteger(1)->defaultValue(1)->notNull()->comment('分类状态'),
            'sort'=>$this->integer()->defaultValue(20)->notNull()->comment('分类排序'),
            'is_help'=>$this->integer()->defaultValue(1)->notNull()->comment('是否为帮助相关的分类')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
