<?php

use yii\db\Migration;

/**
 * Class m180628_084007_add_column_to_vendor_table
 */
class m180628_084007_add_column_to_vendor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('vendor','tel',$this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vendor','tel');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180628_084007_add_column_to_vendor_table cannot be reverted.\n";

        return false;
    }
    */
}
