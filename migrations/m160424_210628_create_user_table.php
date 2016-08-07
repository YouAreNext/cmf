<?php


use yii\db\Migration;


class m160424_210628_create_user_table extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'password' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
