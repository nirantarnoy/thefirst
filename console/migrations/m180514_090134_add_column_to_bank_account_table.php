<?php

use yii\db\Migration;

/**
 * Class m180514_090134_add_column_to_bank_account_table
 */
class m180514_090134_add_column_to_bank_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('bank_account','party_type_id',$this->integer()->after('party_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('bank_account','party_type_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180514_090134_add_column_to_bank_account_table cannot be reverted.\n";

        return false;
    }
    */
}
