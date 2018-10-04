<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "journal_trans".
 *
 * @property int $id
 * @property int $journal_id
 * @property int $product_id
 * @property double $qty
 * @property int $journal_type_status
 * @property double $line_amount
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $onhand_qty
 * @property int $counted_qty
 * @property int $diff_qty
 * @property int $from_wh
 * @property int $to_wh
 * @property int $from_loc
 * @property int $to_loc
 * @property int $from_lot
 * @property int $to_lot
 * @property int $zone_id
 * @property double $line_price
 */
class JournalTrans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'journal_trans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['journal_id', 'product_id', 'journal_type_status','stock_direction', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'onhand_qty', 'counted_qty', 'diff_qty', 'from_wh', 'to_wh', 'from_loc', 'to_loc', 'from_lot', 'to_lot', 'zone_id'], 'integer'],
            [['qty', 'line_amount', 'line_price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'journal_id' => Yii::t('app', 'Journal ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'qty' => Yii::t('app', 'Qty'),
            'journal_type_status' => Yii::t('app', 'Journal Type Status'),
            'line_amount' => Yii::t('app', 'Line Amount'),
            'stock_direction' => Yii::t('app','Stock Direction'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'onhand_qty' => Yii::t('app', 'Onhand Qty'),
            'counted_qty' => Yii::t('app', 'Counted Qty'),
            'diff_qty' => Yii::t('app', 'Diff Qty'),
            'from_wh' => Yii::t('app', 'From Wh'),
            'to_wh' => Yii::t('app', 'To Wh'),
            'from_loc' => Yii::t('app', 'From Loc'),
            'to_loc' => Yii::t('app', 'To Loc'),
            'from_lot' => Yii::t('app', 'From Lot'),
            'to_lot' => Yii::t('app', 'To Lot'),
            'zone_id' => Yii::t('app', 'Zone ID'),
            'line_price' => Yii::t('app', 'Line Price'),
        ];
    }
}
