<?php

use yii\db\Migration;

class m160424_210428_drop_user_table extends Migration
{
    public function up()
    {
        $this->dropTable('user');
    }

    public function down()
    {

        echo "drop user_table";
        return false;

    }
}
