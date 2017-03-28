<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m170328_045318_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('Ʒ������'),
            'intro'=>$this->text()->comment('���'),
            'sort'=>$this->integer()->defaultValue(1)->comment('����'),
            'status'=>$this->integer(1)->defaultValue(1)->comment('Ʒ��״̬'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}
