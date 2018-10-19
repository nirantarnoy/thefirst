<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sale`.
 */
class m180810_040611_create_sale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sale', [
            'id' => $this->primaryKey(),
            'sale_no'=>$this->string(),
            'trans_date'=>$this->integer(),
            'customer_id'=>$this->integer(),
            'sale_type_id'=>$this->integer(),
            'payment_type_id'=>$this->integer(),
            'discount_per'=>$this->float(),
            'discount_amount'=>$this->float(),
            'sale_total'=>$this->float(),
            'sale_total_text'=>$this->string(),
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
        $this->dropTable('sale');
    }
}
