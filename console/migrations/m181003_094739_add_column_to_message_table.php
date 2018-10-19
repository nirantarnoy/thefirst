<?php

use yii\db\Migration;

/**
 * Class m181003_094739_add_column_to_message_table
 */
class m181003_094739_add_column_to_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('message','lone_id',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('message','loan_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181003_094739_add_column_to_message_table cannot be reverted.\n";

        return false;
    }
    */
}
