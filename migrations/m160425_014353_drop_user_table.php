<?php

use yii\db\Migration;

class m160425_014353_drop_user_table extends Migration
{
    public function up()
    {
        $this->dropTable('user');
    }

    public function down()
    {
        echo "pew";
        return false;
    }
}
