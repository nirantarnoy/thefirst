<?php

use yii\db\Migration;

/**
 * Handles the creation of table `purch`.
 */
class m180905_012934_create_purch_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('purch', [
            'id' => $this->primaryKey(),
            'purch_no'=>$this->string(),
            'purch_date'=>$this->date(),
            'vendor_id'=>$this->integer(),
            'purch_total'=>$this->float(),
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
        $this->dropTable('purch');
    }
}
