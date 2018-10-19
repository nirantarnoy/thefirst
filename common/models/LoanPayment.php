<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "loan_payment".
 *
 * @property int $id
 * @property int $loan_id
 * @property int $period_pay
 * @property int $payment_type
 * @property int $payment_date
 * @property string $payment_by
 * @property double $amount
 * @property double $fee
 * @property double $fine
 * @property int $fine_type
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class LoanPayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loan_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_id'],'required'],
            [['loan_id', 'period_pay', 'payment_type', 'payment_date', 'fine_type', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['amount', 'fee', 'fine'], 'number'],
            [['payment_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'loan_id' => Yii::t('app', 'เลขที่'),
            'period_pay' => Yii::t('app', 'รอบชำระที่'),
            'payment_type' => Yii::t('app', 'วิธีการชำระเงิน'),
            'payment_date' => Yii::t('app', 'วันที่ชำระ'),
            'payment_by' => Yii::t('app', 'ชำระโดย'),
            'amount' => Yii::t('app', 'จำนวนเงิน'),
            'fee' => Yii::t('app', 'ค่าธรรมเนียม'),
            'fine' => Yii::t('app', 'ค่าปรับ'),
            'fine_type' => Yii::t('app', 'ประเภทปรับ'),
            'status' => Yii::t('app', 'สถานะ'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่อ'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
        ];
    }
}
