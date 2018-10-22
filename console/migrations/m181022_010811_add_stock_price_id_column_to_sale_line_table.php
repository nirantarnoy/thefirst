<?php

use yii\db\Migration;

/**
 * Handles adding stock_price_id to table `sale_line`.
 */
class m181022_010811_add_stock_price_id_column_to_sale_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('sale_line', 'stock_price_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('sale_line', 'stock_price_id');
    }
}
