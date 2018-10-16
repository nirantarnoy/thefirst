<?php

use yii\db\Migration;

/**
 * Handles adding sale_ref to table `claim_line`.
 */
class m181016_101730_add_sale_ref_column_to_claim_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('claim_line', 'sale_ref', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('claim_line', 'sale_ref');
    }
}
