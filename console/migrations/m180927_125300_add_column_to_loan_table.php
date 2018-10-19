<?php

use yii\db\Migration;

/**
 * Class m180927_125300_add_column_to_loan_table
 */
class m180927_125300_add_column_to_loan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('loan','end_pay_date',$this->date());
        $this->addColumn('loan','loan_percent',$this->float());
        $this->addColumn('loan','pay_ever_day',$this->integer());
        $this->addColumn('loan','fee_rate',$this->float());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('loan','end_pay_date');
        $this->dropColumn('loan','loan_percent');
        $this->dropColumn('loan','pay_ever_day');
        $this->dropColumn('loan','fee_rate');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180927_125300_add_column_to_loan_table cannot be reverted.\n";

        return false;
    }
    */
}
