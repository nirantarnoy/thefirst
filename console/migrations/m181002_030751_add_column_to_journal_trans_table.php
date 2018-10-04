<?php

use yii\db\Migration;

/**
 * Class m181002_030751_add_column_to_journal_trans_table
 */
class m181002_030751_add_column_to_journal_trans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('journal_trans','stock_direction',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('journal_trans','stock_direction');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181002_030751_add_column_to_journal_trans_table cannot be reverted.\n";

        return false;
    }
    */
}
