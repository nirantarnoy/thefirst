<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_pic`.
 */
class m180930_131831_create_product_pic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_pic', [
            'id' => $this->primaryKey(),
            'product_id'=>$this->integer(),
            'picture'=>$this->string(),
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
        $this->dropTable('product_pic');
    }
}
