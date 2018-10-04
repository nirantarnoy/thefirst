<?php

use yii\db\Migration;

/**
 * Class m171130_131920_add_column_to_vendor_table
 */
class m171130_131920_add_column_to_vendor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('vendor','payment_term',$this->integer());
        $this->addColumn('vendor','payment_type',$this->integer());
        $this->addColumn('vendor','delivery_type',$this->integer());
        $this->addColumn('vendor','lead_time',$this->integer());
        $this->addColumn('vendor','vendor_type',$this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('vendor','payment_term');
        $this->dropColumn('vendor','payment_type');
        $this->dropColumn('vendor','delivery_type');
        $this->dropColumn('vendor','lead_time');
        $this->dropColumn('vendor','vendor_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171130_131920_add_column_to_vendor_table cannot be reverted.\n";

        return false;
    }
    */
}
