<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vendor".
 *
 * @property int $id
 * @property string $vendor_code
 * @property string $name
 * @property string $description
 * @property int $vendor_group_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $payment_term
 * @property int $payment_type
 * @property int $delivery_type
 * @property int $lead_time
 * @property int $vendor_type
 * @property string $id_card
 * @property int $buyer_id
 * @property string $tel
 * @property int $iscompany
 */
class Vendor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vendor_code','name'],'required'],
            [['name'],'unique'],
            [['vendor_group_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'payment_term', 'payment_type', 'delivery_type', 'lead_time', 'vendor_type', 'buyer_id', 'iscompany'], 'integer'],
            [['vendor_code', 'name', 'description', 'id_card', 'tel'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'vendor_code' => Yii::t('app', 'รหัส'),
            'name' => Yii::t('app', 'ชื่อ'),
            'description' => Yii::t('app', 'รายละเอียด'),
            'vendor_group_id' => Yii::t('app', 'กลุ่มผู้ขาย'),
            'status' => Yii::t('app', 'สถานะ'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'payment_term' => Yii::t('app', 'Payment Term'),
            'payment_type' => Yii::t('app', 'Payment Type'),
            'delivery_type' => Yii::t('app', 'Delivery Type'),
            'lead_time' => Yii::t('app', 'Lead Time'),
            'vendor_type' => Yii::t('app', 'Vendor Type'),
            'id_card' => Yii::t('app', 'Id Card'),
            'buyer_id' => Yii::t('app', 'Buyer ID'),
            'tel' => Yii::t('app', 'Tel'),
            'iscompany' => Yii::t('app', 'Iscompany'),
        ];
    }
}
