<?php

use yii\db\Migration;

/**
 * Class m180701_030953_add_column_to_journal_line_table
 */
class m180701_030953_add_column_to_journal_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('journal_trans','zone_id',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropColumn('journal_trans','zone_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180701_030953_add_column_to_journal_line_table cannot be reverted.\n";

        return false;
    }
    */
}
