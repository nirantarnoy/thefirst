<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
date_default_timezone_set('Asia/Bangkok');

class Bank extends \common\models\Bank
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

		 public function findBankinfo($id){
		 	$model = Bank::find()->where(['id'=>$id])->one();
		 	return count($model)>0?$model:null;
		 }
		 public function getLogo($id){
		    $model = Bank::find()->where(['id'=>$id])->one();
		    return count($model)>0?$model->logo:'';
		 }
		  public function getBankname($id){
		    $model = Bank::find()->where(['id'=>$id])->one();
		    return count($model)>0?$model->name:'';
		 }
		 public function getBankshortname($id){
		    $model = Bank::find()->where(['id'=>$id])->one();
		    return count($model)>0?$model->short_name:'';
		 }

}
