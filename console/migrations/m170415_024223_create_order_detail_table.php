<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_detail`.
 */
class m170415_024223_create_order_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order_detail', [
            'id' => $this->primaryKey(),
            'order_info_id'=>$this->integer()->unsigned()->notNull()->comment('订单ID'),
            'goods_id'=>$this->integer()->unsigned()->notNull()->comment('商品ID'),
            'goods_name'=>$this->string(32)->notNull()->comment('商品名'),
            'logo'=>$this->string()->notNull()->comment('LOGO'),
            'price'=>$this->decimal(10,2)->notNull()->comment('价格'),
            'amount'=>$this->integer(10)->unsigned()->notNull()->comment('数量'),
            'total_price'=>$this->decimal(10,2)->notNull()->comment('小计')

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order_detail');
    }
}
