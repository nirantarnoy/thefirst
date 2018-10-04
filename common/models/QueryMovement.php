<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_movement".
 *
 * @property string $name
 * @property string $description
 * @property string $reference
 * @property int $reference_type_id
 * @property int $trans_type
 * @property int $status
 * @property string $journal_no
 * @property int $trans_date
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $product_id
 * @property double $qty
 * @property double $line_amount
 * @property int $from_wh
 * @property int $to_wh
 * @property int $from_loc
 * @property int $to_loc
 * @property int $from_lot
 * @property int $to_lot
 * @property int $diff_qty
 * @property int $id
 */
class QueryMovement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_movement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reference_type_id', 'trans_type', 'status', 'trans_date','stock_direction', 'created_at', 'updated_at', 'created_by', 'updated_by', 'product_id', 'from_wh', 'to_wh', 'from_loc', 'to_loc', 'from_lot', 'to_lot', 'diff_qty', 'id'], 'integer'],
            [['qty', 'line_amount'], 'number'],
            [['name', 'description', 'reference', 'journal_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'ชื่อรายการ'),
            'description' => Yii::t('app', 'รายละเอียด'),
            'reference' => Yii::t('app', 'อ้างอิงเลขที่'),
            'reference_type_id' => Yii::t('app', 'Reference Type ID'),
            'trans_type' => Yii::t('app', 'ประเภทรายการ'),
            'status' => Yii::t('app', 'Status'),
            'journal_no' => Yii::t('app', 'เลขที่รายการ'),
            'trans_date' => Yii::t('app', 'วันที่'),
            'stock_direction' => Yii::t('app', 'ประเภทสต๊อก'),
            'created_at' => Yii::t('app', 'วันที่ทำรายการ'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'ผู้ดำเนินการ'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'product_id' => Yii::t('app', 'รหัสสินค้า'),
            'qty' => Yii::t('app', 'จำนวน'),
            'line_amount' => Yii::t('app', 'ยอดเงิน'),
            'from_wh' => Yii::t('app', 'From Wh'),
            'to_wh' => Yii::t('app', 'To Wh'),
            'from_loc' => Yii::t('app', 'From Loc'),
            'to_loc' => Yii::t('app', 'To Loc'),
            'from_lot' => Yii::t('app', 'From Lot'),
            'to_lot' => Yii::t('app', 'To Lot'),
            'diff_qty' => Yii::t('app', 'Diff Qty'),
            'id' => Yii::t('app', 'ID'),
        ];
    }
}
