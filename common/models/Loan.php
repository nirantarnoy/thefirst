<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "loan".
 *
 * @property int $id
 * @property string $loan_no
 * @property int $loan_date
 * @property int $sale_id
 * @property string $personal_id
 * @property int $period_type
 * @property int $factor
 * @property int $period
 * @property double $payment_per
 * @property double $first_pay
 * @property int $first_pay_date
 * @property int $next_pay_date
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Loan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_no'],'required'],
            [['loan_date','append_date', 'sale_id', 'period_type', 'factor', 'period', 'first_pay_date', 'next_pay_date', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['payment_per', 'first_pay'], 'number'],
            [['loan_no'], 'string', 'max' => 255],
            [['personal_id'], 'string', 'max' => 13],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'loan_no' => Yii::t('app', 'เลขที่'),
            'loan_date' => Yii::t('app', 'วันที่'),
            'sale_id' => Yii::t('app', 'เลขที่ซื้อ'),
            'personal_id' => Yii::t('app', 'รหัสบัตรลูกค้า'),
            'period_type' => Yii::t('app', 'ประเภทงวด'),
            'factor' => Yii::t('app', 'Factor'),
            'period' => Yii::t('app', 'จำนวนงวด'),
            'payment_per' => Yii::t('app', 'จำนวนเงิน/งวด'),
            'first_pay' => Yii::t('app', 'จำนวนชำระงวดแรก'),
            'first_pay_date' => Yii::t('app', 'วันที่ต้องชำระงวดแรก'),
            'next_pay_date' => Yii::t('app', 'ชำระครั้งต่อไป'),
            'append_date' => Yii::t('app', 'เลื่อนชำระ'),
            'status' => Yii::t('app', 'สถานะ'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่อt'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
        ];
    }
}
