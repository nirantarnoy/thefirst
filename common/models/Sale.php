<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale".
 *
 * @property int $id
 * @property string $sale_no
 * @property int $trans_date
 * @property int $customer_id
 * @property int $sale_type_id
 * @property int $payment_type_id
 * @property double $discount_per
 * @property double $discount_amount
 * @property double $sale_total
 * @property string $sale_total_text
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Sale extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_no','customer_id'],'required'],
            [[ 'customer_id', 'sale_type_id', 'payment_type_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['discount_per', 'discount_amount', 'sale_total'], 'number'],
            [['sale_no', 'sale_total_text'], 'string', 'max' => 255],
            [['trans_date'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sale_no' => Yii::t('app', 'เลขที่'),
            'trans_date' => Yii::t('app', 'วันที่'),
            'customer_id' => Yii::t('app', 'รหัสลูกค้า'),
            'sale_type_id' => Yii::t('app', 'ประเภทขาย'),
            'payment_type_id' => Yii::t('app', 'วิธีชำระเงิน'),
            'discount_per' => Yii::t('app', 'ส่วนลด %'),
            'discount_amount' => Yii::t('app', 'ส่วนลด'),
            'sale_total' => Yii::t('app', 'รวมขาย'),
            'sale_total_text' => Yii::t('app', 'รวมขายตัวหนังสือ'),
            'status' => Yii::t('app', 'สถานะ'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่อ'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
        ];
    }
}
