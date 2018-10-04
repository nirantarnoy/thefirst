<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "province".
 *
 * @property int $PROVINCE_ID
 * @property string $PROVINCE_CODE
 * @property string $PROVINCE_NAME
 * @property int $GEO_ID
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'province';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PROVINCE_CODE', 'PROVINCE_NAME'], 'required'],
            [['GEO_ID'], 'integer'],
            [['PROVINCE_CODE'], 'string', 'max' => 2],
            [['PROVINCE_NAME'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PROVINCE_ID' => Yii::t('app', 'P R O V I N C E I D'),
            'PROVINCE_CODE' => Yii::t('app', 'P R O V I N C E C O D E'),
            'PROVINCE_NAME' => Yii::t('app', 'P R O V I N C E N A M E'),
            'GEO_ID' => Yii::t('app', 'G E O I D'),
        ];
    }
}
