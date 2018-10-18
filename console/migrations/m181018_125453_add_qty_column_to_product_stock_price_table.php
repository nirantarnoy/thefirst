<?php

use yii\db\Migration;

/**
 * Handles adding qty to table `product_stock_price`.
 */
class m181018_125453_add_qty_column_to_product_stock_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product_stock_price', 'qty', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('product_stock_price', 'qty');
    }
}
