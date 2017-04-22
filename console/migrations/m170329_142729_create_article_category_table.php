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
            'name'=>$this->string(50)->notNull()->comment('��������'),
            'intro'=>$this->text()->comment('������'),
            'status'=>$this->smallInteger(1)->defaultValue(1)->notNull()->comment('����״̬'),
            'sort'=>$this->integer()->defaultValue(20)->notNull()->comment('��������'),
            'is_help'=>$this->integer()->defaultValue(1)->notNull()->comment('�Ƿ�Ϊ������صķ���')
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
