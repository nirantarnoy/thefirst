<?php

use yii\db\Migration;

/**
 * Class m180926_122717_add_column_to_purch_line_table
 */
class m180926_122717_add_column_to_purch_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('purch_line','remain_qty',$this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
     $this->dropColumn('purch_line','remain_qty');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180926_122717_add_column_to_purch_line_table cannot be reverted.\n";

        return false;
    }
    */
}
