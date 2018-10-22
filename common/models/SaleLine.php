<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_line".
 *
 * @property int $id
 * @property int $sale_id
 * @property int $product_id
 * @property int $qty
 * @property double $price
 * @property double $line_disc_per
 * @property double $line_disc_amount
 * @property double $line_total
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class SaleLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_id'],'integer'],
            [['sale_id','stock_price_id', 'product_id', 'qty', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['price', 'line_disc_per', 'line_disc_amount', 'line_total'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sale_id' => Yii::t('app', 'Sale ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'qty' => Yii::t('app', 'Qty'),
            'price' => Yii::t('app', 'Price'),
            'line_disc_per' => Yii::t('app', 'Line Disc Per'),
            'line_disc_amount' => Yii::t('app', 'Line Disc Amount'),
            'line_total' => Yii::t('app', 'Line Total'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่อ'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
        ];
    }
}
