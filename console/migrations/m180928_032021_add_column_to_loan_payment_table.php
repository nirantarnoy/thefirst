<?php

use yii\db\Migration;

/**
 * Class m180928_032021_add_column_to_loan_payment_table
 */
class m180928_032021_add_column_to_loan_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('loan_payment','note',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('loan_payment','note');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180928_032021_add_column_to_loan_payment_table cannot be reverted.\n";

        return false;
    }
    */
}
