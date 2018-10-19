<?php

use yii\db\Migration;

/**
 * Handles the creation of table `claim_line`.
 */
class m181010_101755_create_claim_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('claim_line', [
            'id' => $this->primaryKey(), 'status'=>$this->integer(),
            'claim_id' => $this->integer(),
            'product_id' => $this->integer(),
            'qty' => $this->float(),
            'problem'=>$this->string(),
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
        $this->dropTable('claim_line');
    }
}
