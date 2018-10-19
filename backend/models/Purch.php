<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
date_default_timezone_set('Asia/Bangkok');

class Purch extends \common\models\Purch
{
    public function behaviors()
    {
        return [
            'timestampcdate'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>'created_at',
                ],
                'value'=> time(),
            ],
            'timestampudate'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>'updated_at',
                ],
                'value'=> time(),
            ],
            'timestampcby'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>'created_by',
                ],
                'value'=> Yii::$app->user->identity->id,
            ],
            'timestamuby'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_by',
                ],
                'value'=> Yii::$app->user->identity->id,
            ],
            'timestampupdate'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_at',
                ],
                'value'=> time(),
            ],
        ];
    }

    public function findCode($id){
        $model = Customer::find()->where(['id'=>$id])->one();
        return count($model)>0?$model->code:'';
    }
//    public function findFullname($id){
//        $model = Customer::find()->where(['id'=>$id])->one();
//        return count($model)>0?$model->first_name.' '.$model->last_name:'';
//    }
//    public function findId($code){
//        $model = Customer::find()->where(['code'=>$code])->one();
//        return count($model)>0?$model->id:0;
//    }
    public function getLastNo($trans_type){
        $model = \backend\models\Purch::find()->MAX('purch_no');
//        $pre = \backend\models\Sequence::find()->where(['module_id'=>$trans_type])->one();
        if($model){
            $prefix = substr(date("Y"),2,2);
            $cnum = substr((string)$model,strlen($prefix),strlen($model));
            $len = strlen($cnum);
            $clen = strlen($cnum + 1);
            $loop = $len - $clen;
            for($i=1;$i<=$loop;$i++){
                $prefix.="0";
            }
            $prefix.=$cnum + 1;
            return $prefix;
        }else{
            $prefix =substr(date("Y"),2,2);
            return $prefix.'000001';
        }
    }
    public function getRecsum($id){
        $model = \backend\models\Purchline::find()->where(['purch_id'=>$id])->sum('remain_qty');
        return $model >0?$model:0;
    }
}
