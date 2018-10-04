<?php

use yii\db\Migration;

/**
 * Handles the creation of table `loan_pospone`.
 */
class m180930_151727_create_loan_pospone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('loan_pospone', [
            'id' => $this->primaryKey(),
            'loan_id'=>$this->integer(),
            'before_date'=>$this->integer(),
            'new_date'=>$this->integer(),
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
        $this->dropTable('loan_pospone');
    }
}
