<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "journal".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $reference
 * @property int $reference_type_id
 * @property int $trans_type
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $trans_date
 * @property string $journal_no
 */
class Journal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'journal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reference_type_id', 'trans_type', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'trans_date'], 'integer'],
            [['name', 'description', 'reference', 'journal_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'ชื่อ'),
            'description' => Yii::t('app', 'รายละเอียด'),
            'reference' => Yii::t('app', 'อ้างอิง'),
            'reference_type_id' => Yii::t('app', 'ประเภทอ้างอิง'),
            'trans_type' => Yii::t('app', 'Trans Type'),
            'status' => Yii::t('app', 'สถานะ'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่อ'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
            'trans_date' => Yii::t('app', 'วันที่'),
            'journal_no' => Yii::t('app', 'เลขที่'),
        ];
    }
}
