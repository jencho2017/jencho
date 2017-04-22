<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cart`.
 */
class m170414_042611_create_cart_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cart', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->comment('用户ID'),
            'goods_id'=>$this->integer()->comment('商品ID'),
            'amount'=>$this->integer()->comment('数量'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cart');
    }
}
