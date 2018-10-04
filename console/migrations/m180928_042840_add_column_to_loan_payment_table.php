<?php

use yii\db\Migration;

/**
 * Class m180928_042840_add_column_to_loan_payment_table
 */
class m180928_042840_add_column_to_loan_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('loan_payment','periodof',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('loan_payment','periodof');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180928_042840_add_column_to_loan_payment_table cannot be reverted.\n";

        return false;
    }
    */
}
