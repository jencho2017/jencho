<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_gallery`.
 */
class m170331_160917_create_goods_gallery_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_gallery', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->bigInteger()->comment('商品ID'),
            'path'=>$this->string(255)->notNull()->comment('相册地址'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_gallery');
    }
}
