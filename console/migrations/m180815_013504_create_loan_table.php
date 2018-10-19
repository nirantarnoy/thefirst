<?php

use yii\db\Migration;

/**
 * Handles the creation of table `loan`.
 */
class m180815_013504_create_loan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('loan', [
            'id' => $this->primaryKey(),
            'loan_no'=>$this->string(),
            'loan_date'=>$this->integer(),
            'sale_id'=>$this->integer(),
            'personal_id'=>$this->string(13),
            'period_type'=>$this->integer(),
            'factor'=>$this->integer(),
            'period'=>$this->integer(),
            'payment_per'=>$this->float(),
            'first_pay'=>$this->float(),
            'first_pay_date'=>$this->integer(),
            'next_pay_date'=>$this->integer(),
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
        $this->dropTable('loan');
    }
}
