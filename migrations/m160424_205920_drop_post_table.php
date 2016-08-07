<?php

use yii\db\Migration;

class m160424_205920_drop_post_table extends Migration
{
    public function up()
    {
        $this->dropTable('post');
    }

    public function down()
    {
        echo "cannot be retrived";
        return false;
    }
}
