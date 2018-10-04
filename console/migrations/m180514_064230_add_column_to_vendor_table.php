<?php

use yii\db\Migration;

/**
 * Class m180514_064230_add_column_to_vendor_table
 */
class m180514_064230_add_column_to_vendor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vendor','vendor_code',$this->string()->after('id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vendor','vendor_code');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180514_064230_add_column_to_vendor_table cannot be reverted.\n";

        return false;
    }
    */
}
