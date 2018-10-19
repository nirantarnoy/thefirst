<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_stock_price`.
 */
class m181018_105341_create_product_stock_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_stock_price', [
            'id' => $this->primaryKey(),
            'product_id'=>$this->integer(),
            'price'=>$this->float(),
            'journal_line_id'=>$this->integer(),
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
        $this->dropTable('product_stock_price');
    }
}
