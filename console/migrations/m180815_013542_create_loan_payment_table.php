<?php

use yii\db\Migration;

/**
 * Handles the creation of table `loan_payment`.
 */
class m180815_013542_create_loan_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('loan_payment', [
            'id' => $this->primaryKey(),
            'loan_id'=>$this->integer(),
            'period_pay'=>$this->integer(),
            'payment_type'=>$this->integer(),
            'payment_date'=>$this->integer(),
            'payment_by'=>$this->string(),
            'amount'=>$this->float(),
            'fee'=>$this->float(),
            'fine'=>$this->float(),
            'fine_type'=>$this->integer(),
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
        $this->dropTable('loan_payment');
    }
}
