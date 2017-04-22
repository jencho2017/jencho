<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m170329_142252_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('文章名'),
            'article_category_id'=>$this->integer()->notNull()->comment('分类ID'),
            'intro'=>$this->text()->notNull()->notNull()->comment('文章简介'),
            'status'=>$this->smallInteger(1)->notNull()->defaultValue(1)->comment('文章状态'),
            'sort'=>$this->integer()->defaultValue(20)->comment('文章排序'),
            'inputtime'=>$this->integer()->comment('添加时间'),
            'update_time'=>$this->integer()->comment('最近一次修改时间')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
