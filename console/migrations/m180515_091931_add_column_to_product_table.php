<?php

use yii\db\Migration;

/**
 * Class m180515_091931_add_column_to_product_table
 */
class m180515_091931_add_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product','check_avl',$this->integer());
        $this->addColumn('product','netweight',$this->float());
        $this->addColumn('product','tareweight',$this->float());
        $this->addColumn('product','grossweight',$this->float());
        $this->addColumn('product','date_price',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('product','check_avl');
        $this->dropColumn('product','netweight');
        $this->dropColumn('product','tareweight');
        $this->dropColumn('product','grossweight');
        $this->dropColumn('product','date_price');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180515_091931_add_column_to_product_table cannot be reverted.\n";

        return false;
    }
    */
}
