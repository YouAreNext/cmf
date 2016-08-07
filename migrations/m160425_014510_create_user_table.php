<?php

use yii\db\Migration;

class m160425_014510_create_user_table extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'password_hash' =>$this->string()->notNull(),
            'status' =>$this->smallInteger()->notNull(),
            'auth_key' =>$this->string(32)->notNull(),
            'created_at' =>$this->integer()->notNull(),
            'updated_at' =>$this->integer()->notNull(),
            'roles' =>$this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
