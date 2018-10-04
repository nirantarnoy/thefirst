<?php

use yii\db\Migration;

/**
 * Class m180711_020515_add_column_to_vendor_table
 */
class m180711_020515_add_column_to_vendor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vendor','iscompany',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vendor','iscompany');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180711_020515_add_column_to_vendor_table cannot be reverted.\n";

        return false;
    }
    */
}
