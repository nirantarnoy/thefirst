<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purch_line".
 *
 * @property int $id
 * @property int $purch_id
 * @property int $product_id
 * @property double $qty
 * @property double $price
 * @property double $disc_amount
 * @property double $disc_per
 * @property double $line_amount
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class PurchLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purch_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['purch_id','product_id'],'required'],
            [['purch_id', 'product_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['qty', 'price', 'disc_amount', 'disc_per', 'line_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'purch_id' => Yii::t('app', 'Purch ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'qty' => Yii::t('app', 'Qty'),
            'price' => Yii::t('app', 'Price'),
            'disc_amount' => Yii::t('app', 'Disc Amount'),
            'disc_per' => Yii::t('app', 'Disc Per'),
            'line_amount' => Yii::t('app', 'Line Amount'),
            'status' => Yii::t('app', 'สถานะ'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่อ'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
        ];
    }
}
