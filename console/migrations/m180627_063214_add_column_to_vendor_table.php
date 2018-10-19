<?php

use yii\db\Migration;

/**
 * Class m180627_063214_add_column_to_vendor_table
 */
class m180627_063214_add_column_to_vendor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('vendor','buyer_id',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropColumn('vendor','buyer_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180627_063214_add_column_to_vendor_table cannot be reverted.\n";

        return false;
    }
    */
}
