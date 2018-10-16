<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "claim_line".
 *
 * @property int $id
 * @property int $status
 * @property int $claim_id
 * @property int $product_id
 * @property double $qty
 * @property string $problem
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class ClaimLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'claim_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['claim_id'],'required'],
            [['status', 'claim_id', 'product_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['qty'], 'number'],
            [['problem'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'claim_id' => Yii::t('app', 'Claim ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'qty' => Yii::t('app', 'Qty'),
            'sale_ref'=>Yii::t('app','เลขที่อ้างอิง'),
            'problem' => Yii::t('app', 'Problem'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่่อ'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
        ];
    }
}
