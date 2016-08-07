<?php

use yii\db\Migration;

class m160428_140749_create_profile_table extends Migration
{
    public function safeUp()
    {
        $this->createTable(
            'profile',
            [
                'user_id' => $this->primaryKey(),
                'avatar' => $this->string(),
                'first_name' => $this->string(32),
                'second_name' => $this->string(32),
                'middle_name' => $this->string(32),
                'birthday' => $this->integer(),
                'gender' => $this->smallInteger(),
            ]
        );
        $this->addForeignKey('profile_user','profile','user_id','user','id','cascade','cascade');
    }

    public function safeDown()
    {
        $this->dropForeignKey('profile_user');
        $this->dropTable('profile');
    }
}
