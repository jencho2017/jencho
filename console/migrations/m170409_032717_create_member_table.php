<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m170409_032717_create_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique()->comment('用户名'),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            //'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique()->comment('邮箱'),
            'tel'=>$this->char(11)->notNull()->comment('电话'),
            'last_login_time'=>$this->integer()->comment('上一次登陆时间'),
            //211.123.110.119
            //ip2long('211.123.110.119')
            //long2ip()
            'last_login_ip'=>$this->integer()->comment('最近一次登陆IP'),
            'status' => $this->smallInteger()->defaultValue(10),
            'created_at' => $this->integer()->comment('注册时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('member');
    }
}
