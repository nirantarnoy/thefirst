<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_balance".
 *
 * @property int $id
 * @property int $product_id
 * @property int $warehouse_id
 * @property int $loc_id
 * @property double $qty
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class StockBalance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock_balance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id','warehouse_id'],'required'],
            [['product_id', 'warehouse_id', 'loc_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['qty'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'รหัสสินค้า'),
            'warehouse_id' => Yii::t('app', 'คลังสินค้า'),
            'loc_id' => Yii::t('app', 'ล๊อก'),
            'qty' => Yii::t('app', 'จำนวน'),
            'status' => Yii::t('app', 'สถานะ'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่อ'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
        ];
    }
}
