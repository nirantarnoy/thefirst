<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sale_line`.
 */
class m180810_040617_create_sale_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sale_line', [
            'id' => $this->primaryKey(),
            'sale_id'=>$this->integer(),
            'product_id'=>$this->integer(),
            'qty'=>$this->integer(),
            'price'=>$this->float(),
            'line_disc_per'=>$this->float(),
            'line_disc_amount'=>$this->float(),
            'line_total'=>$this->float(),
            'status' => $this->integer(),
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
        $this->dropTable('sale_line');
    }
}
