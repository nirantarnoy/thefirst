<?php

use yii\db\Migration;

/**
 * Class m180619_081118_add_column_to_vendor_table
 */
class m180619_081118_add_column_to_vendor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->addColumn('vendor','id_card',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('vendor','id_card');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180619_081118_add_column_to_vendor_table cannot be reverted.\n";

        return false;
    }
    */
}
