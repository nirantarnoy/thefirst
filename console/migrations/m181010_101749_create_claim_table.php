<?php

use yii\db\Migration;

/**
 * Handles the creation of table `claim`.
 */
class m181010_101749_create_claim_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('claim', [
            'id' => $this->primaryKey(),
            'claim_no' => $this->string(),
            'trans_date' => $this->integer(),
            'sale_no' => $this->integer(),
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
        $this->dropTable('claim');
    }
}
