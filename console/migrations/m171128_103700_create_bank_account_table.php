<?php

use yii\db\Migration;

/**
 * Handles the creation of table `bank_account`.
 */
class m171128_103700_create_bank_account_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('bank_account', [
            'id' => $this->primaryKey(),
            'party_id' => $this->integer(),
            'account_type_id' => $this->integer(),
            'account_name' => $this->string(),
            'account_no' => $this->string(),
            'branch' => $this->string(),
            'is_primary'=> $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('bank_account');
    }
}
