<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menus`.
 */
class m170406_031108_create_menus_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menus', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull()->comment('菜单名'),
            'parent_id' => $this->integer()->notNull()->comment('上级分类'),
            'url' => $this->string()->comment('路由'),
            'description' => $this->string()->comment('描述'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menus');
    }
}
