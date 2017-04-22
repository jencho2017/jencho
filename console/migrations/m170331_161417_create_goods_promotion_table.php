<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_promotion`.
 */
class m170331_161417_create_goods_promotion_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_promotion', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer()->notNull()->comment('商品ID'),
            'promotion_id'=>$this->integer()->notNull()->comment('促销ID'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_promotion');
    }
}
