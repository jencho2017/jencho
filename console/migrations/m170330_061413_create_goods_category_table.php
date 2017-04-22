<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m170330_061413_create_goods_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->comment('分类名称'),
            'parent_id'=>$this->integer()->notNull()->comment('上一级分类id'),
            'intro'=>$this->text()->comment('分类简介')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_category');
    }
}
