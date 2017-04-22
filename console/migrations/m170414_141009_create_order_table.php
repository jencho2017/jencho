<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m170414_141009_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer()->comment('用户ID'),
            'name'=>$this->string()->comment('收货人'),
            'province_name'=>$this->string()->comment('省份'),
            'city_name'=>$this->string()->comment('城市'),
            'area_name'=>$this->string()->comment('地区'),
            'detail_address'=>$this->string()->comment('详细地址'),
            'tel'=>$this->integer()->comment('联系电话'),
            'delivery_id'=>$this->integer()->unsigned()->comment('配送方式ID'),
            'delivery_name'=>$this->string()->comment('配送方式的名字'),
            'delivery_price'=>$this->decimal()->comment('运费'),
            'pay_type_id'=>$this->integer()->unsigned()->comment('支付方式ID'),
            'pay_type_name'=>$this->string()->comment('支付方式'),
            'price'=>$this->decimal()->comment('商品金额'),
            'status'=>$this->integer()->comment('订单状态'),
            'trode_no'=>$this->string(30)->comment('第三方支付的交易号'),
            'create_time'=>$this->integer()->unsigned()->comment('添加时间')

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
