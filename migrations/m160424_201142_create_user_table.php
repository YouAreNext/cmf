<?php

use yii\db\Migration;

class m160424_201142_create_user_table extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => 'pk',
            'password' => 'string NOT NULL',
            'email' => 'string NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
