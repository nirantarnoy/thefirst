<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pay`.
 */
class m180924_052138_create_pay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('pay', [
            'id' => $this->primaryKey(),
            'pay_date' => $this->dateTime(),
            'loan_id' =>$this->integer(),
            'preriod' => $this->integer(),
            'amount' => $this->float(),
            'pay_from'=>$this->integer(),
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
        $this->dropTable('pay');
    }
}
