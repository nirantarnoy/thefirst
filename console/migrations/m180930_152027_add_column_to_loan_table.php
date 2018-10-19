<?php

use yii\db\Migration;

/**
 * Class m180930_152027_add_column_to_loan_table
 */
class m180930_152027_add_column_to_loan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
     $this->addColumn('loan','append_date',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('loan','append_date');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180930_152027_add_column_to_loan_table cannot be reverted.\n";

        return false;
    }
    */
}
