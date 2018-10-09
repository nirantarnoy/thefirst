<?php

use yii\db\Migration;

/**
 * Handles adding phone to table `customer`.
 */
class m181009_061158_add_phone_column_to_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer', 'phone', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('customer', 'phone');
    }
}
