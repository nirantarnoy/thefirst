<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
date_default_timezone_set('Asia/Bangkok');

class Journal extends \common\models\Journal
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

//    public function findLocationinfo($id){
//        $model = Location::find()->where(['id'=>$id])->one();
//        return count($model)>0?$model:null;
//    }
    public static function createTrans($stock_type,$data,$refid,$trans_type){

        $model = new \backend\models\Journal();
        $model->journal_no = "";
        $model->trans_date = time("U");
        $model->trans_type = $trans_type;
        $model->reference_type_id = $refid; // ประเภทกิจกรรม
        $model->journal_no = self::getLastNo();
        if($model->save()){
            $saveok = 0;
            if(count($data)>0){
                for($i=0;$i<=count($data)-1;$i++){
                    $modelline = new \backend\models\JournalLine();
                    $modelline->journal_id = $model->id;
                    $modelline->product_id = $data[$i]['product_id'];
                    $modelline->to_wh = 1;
                    $modelline->to_loc = 1;
                    $modelline->qty = $data[$i]['qty'];
                    $modelline->line_price = $data[$i]['line_price'];
                    $modelline->line_amount = (float)$data[$i]['qty'] * (float)$data[$i]['line_price'];
                    $modelline->stock_direction = $data[$i]['stock_line_type'];

                    if($modelline->save(false)){
                        $saveok = 1;
                        if($trans_type == \backend\helpers\JournalType::TYPE_PO){
                            self::updatePoRemain($refid,$data[$i]['product_id'],$data[$i]['qty']);

                            $modelstockprice = new \backend\models\Productstockprice();
                            $modelstockprice->product_id = $data[$i]['product_id'];
                            $modelstockprice->price = $data[$i]['line_price'];
                            $modelstockprice->journal_line_id = $modelline->id;
                            $modelstockprice->save(false);
                        }
                    }
                }
            }
            if($saveok){
               self::updateStock($stock_type,$data,$trans_type);
            }
            return true;
        }
    }
    private static function updateStock($type,$data,$trans_type){
        if(count($data)){
            for($i=0;$i<=count($data)-1;$i++){
                $model = \backend\models\Stockbalance::find()->where(['product_id'=>$data[$i]['product_id'],'warehouse_id'=>$data[$i]['warehouse_id']])->one();
                if($model){
                    $old_qty = $model->qty;
                    if($type == 1){ //ยอดเข้า
                        $model->qty = $old_qty + (float)$data[$i]['qty'];
                    }else{
                        $model->qty = $old_qty - (float)$data[$i]['qty'];
                    }

                    $model->save();
                }else{
                    $model = new \backend\models\Stockbalance();
                    $model->warehouse_id = $data[$i]['warehouse_id'];
                    $model->product_id = $data[$i]['product_id'];
                    $model->loc_id = 1;
                    $model->qty = $data[$i]['qty'];
                    $model->save();
                }
               self::updateProductQty($data[$i]['product_id']);
            }

        }
        return true;
    }
    public static function updateProductQty($id){
        $stock = \backend\models\Stockbalance::find()->where(['product_id'=>$id])->sum('qty');
        $model = \backend\models\Product::find()->where(['id'=>$id])->one();
        $model->all_qty = $stock;
        $model->save();
    }
    public static function updatePoRemain($id,$prodid,$qty){
        $model = \backend\models\Purchline::find()->where(['purch_id'=>$id,'product_id'=>$prodid])->one();
        if($model){
            $model->remain_qty = $model->remain_qty - (float)$qty;
            $model->save(false);
        }
    }
    public function getLastNo(){
        $model = \backend\models\Journal::find()->MAX('journal_no');
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

}
