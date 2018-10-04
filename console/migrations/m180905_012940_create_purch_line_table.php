<?php

use yii\db\Migration;

/**
 * Handles the creation of table `purch_line`.
 */
class m180905_012940_create_purch_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('purch_line', [
            'id' => $this->primaryKey(),
            'purch_id'=>$this->integer(),
            'product_id'=>$this->integer(),
            'qty'=>$this->float(),
            'price'=>$this->float(),
            'disc_amount'=>$this->float(),
            'disc_per'=>$this->float(),
            'line_amount'=>$this->float(),
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
        $this->dropTable('purch_line');
    }
}
