<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pay".
 *
 * @property int $id
 * @property string $pay_date
 * @property int $loan_id
 * @property int $preriod
 * @property double $amount
 * @property int $pay_from
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Pay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pay';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pay_date'], 'safe'],
            [['loan_id', 'preriod', 'pay_from', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pay_date' => Yii::t('app', 'Pay Date'),
            'loan_id' => Yii::t('app', 'Loan ID'),
            'preriod' => Yii::t('app', 'Preriod'),
            'amount' => Yii::t('app', 'Amount'),
            'pay_from' => Yii::t('app', 'Pay From'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
