<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "claim".
 *
 * @property int $id
 * @property string $claim_no
 * @property int $trans_date
 * @property int $sale_no
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Claim extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'claim';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['claim_no'],'required'],
            [['trans_date', 'sale_no', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['claim_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'claim_no' => Yii::t('app', 'เลขทีใบเคลม'),
            'trans_date' => Yii::t('app', 'วันที่'),
            'sale_no' => Yii::t('app', 'ใบสั่งซื้อ'),
            'status' => Yii::t('app', 'สถาณะ'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่่อ'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
        ];
    }
}
