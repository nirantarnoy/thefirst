<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_price`.
 */
class m180928_075201_create_product_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_price', [
            'id' => $this->primaryKey(),
            'product_id'=>$this->integer(),
            'vendor_id'=>$this->integer(),
            'price'=>$this->float(),
            'status'=>$this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product_price');
    }
}
