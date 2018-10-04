<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bank_account".
 *
 * @property int $id
 * @property int $party_id
 * @property int $account_type_id
 * @property string $account_name
 * @property string $account_no
 * @property string $branch
 * @property int $is_primary
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class BankAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bank_account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['party_id', 'account_type_id', 'is_primary', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['account_name', 'account_no', 'branch'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'party_id' => Yii::t('app', 'Party ID'),
            'account_type_id' => Yii::t('app', 'Account Type ID'),
            'account_name' => Yii::t('app', 'Account Name'),
            'account_no' => Yii::t('app', 'Account No'),
            'branch' => Yii::t('app', 'Branch'),
            'is_primary' => Yii::t('app', 'Is Primary'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
