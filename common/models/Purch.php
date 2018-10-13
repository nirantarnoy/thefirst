<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purch".
 *
 * @property int $id
 * @property string $purch_no
 * @property string $purch_date
 * @property int $vendor_id
 * @property double $purch_total
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Purch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['purch_no','vendor_id'],'required'],
            [['purch_date'], 'safe'],
            [['vendor_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['purch_total'], 'number'],
            [['purch_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'purch_no' => Yii::t('app', 'เลขที่'),
            'purch_date' => Yii::t('app', 'วันที่'),
            'vendor_id' => Yii::t('app', 'รหัสผู้ขาย'),
            'purch_total' => Yii::t('app', 'ยอดซื้อ'),
            'status' => Yii::t('app', 'สถานะ'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่อ'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
        ];
    }
}
