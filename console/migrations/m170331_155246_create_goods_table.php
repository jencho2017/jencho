<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m170331_155246_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('商品名称'),
            'sn'=>$this->string(15)->notNull()->comment('货号'),
            'logo'=>$this->string(150)->notNull()->comment('货号'),
            'goods_category_id'=>$this->smallInteger(3)->unsigned()->notNull()->comment('商品分类ID'),
            'brand_id'=>$this->smallInteger(5)->unsigned()->notNull()->comment('品牌ID'),
            'market_price'=>$this->decimal(10,2)->unsigned()->notNull()->comment('市场价格'),
            'shop_price'=>$this->decimal(10,2)->unsigned()->notNull()->comment('本店价格'),
            'stock'=>$this->integer()->notNull()->comment('库存'),
            'is_on_sale'=>$this->smallInteger(4)->notNull()->comment('是否上架'),
            'status'=>$this->smallInteger(4)->notNull()->comment('商品状态'),
            'sort'=>$this->smallInteger(4)->notNull()->comment('商品排序'),
            'inputtime'=>$this->integer()->notNull()->comment('添加时间'),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
