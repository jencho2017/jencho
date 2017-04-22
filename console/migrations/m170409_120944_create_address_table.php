<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m170409_120944_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->comment('收货人'),
            'user_id' => $this->integer()->comment('用户ID'),
            'provience' => $this->string()->notNull()->comment('省份'),
            'city' => $this->string()->notNull()->comment('省份'),
            'area' => $this->string()->notNull()->comment('省份'),
            'tel' => $this->integer()->notNull()->comment('联系电话'),
            'detail' => $this->string()->notNull()->comment('详细地址'),
            'status' => $this->smallInteger(1)->defaultValue(0)->comment('是否为默认地址'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}
