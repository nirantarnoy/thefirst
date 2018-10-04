<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
date_default_timezone_set('Asia/Bangkok');

class Warehouse extends \common\models\Warehouse
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
		 public function findWarehousename($id){
		 	$model = Warehouse::find()->where(['id'=>$id])->one();
		 	return count($model)>0?$model->name:'';
		 }
        public function findWarehouseinfo($id){
            $model = Warehouse::find()->where(['id'=>$id])->one();
            return count($model)>0?$model:null;
        }

}
