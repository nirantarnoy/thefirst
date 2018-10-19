<?php

namespace backend\controllers;

use Yii;
use backend\models\Purch;
use backend\models\PurchSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use backend\models\Journal;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
/**
 * PurchController implements the CRUD actions for Purch model.
 */
class PurchController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST','GET'],
                ],
            ],
//            'access'=>[
//                'class'=>AccessControl::className(),
//                'rules'=>[
//                    [
//                        'allow'=>true,
//                        'actions'=>['index','create','update','delete','view','finditem'],
//                        'roles'=>['@'],
//                    ]
//                ]
//            ]
            'access'=>[
                'class'=>AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new ForbiddenHttpException('คุณไม่ได้รับอนุญาติให้เข้าใช้งาน!');
                },
                'rules'=>[
//                    [
//                        'allow'=>true,
//                        'actions'=>['index','create','update','delete','view'],
//                        'roles'=>['@'],
//                    ]
                    [
                        'allow'=>true,
                        'roles'=>['@'],
                        'matchCallback'=>function($rule,$action){
                            $currentRoute = Yii::$app->controller->getRoute();
                            if(Yii::$app->user->can($currentRoute)){
                                return true;
                            }
                        }
                    ]
                ]
            ]

        ];
    }

    /**
     * Lists all Purch models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $data = [];
//        array_push($data,['product_id'=>1,'warehouse_id'=>1,'qty'=>100]);
//        array_push($data,['product_id'=>2,'warehouse_id'=>1,'qty'=>700]);
//
//        //print_r($data);return;
//        Journal::createTrans(1,$data);

        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new PurchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Purch model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Purch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Purch();

        if ($model->load(Yii::$app->request->post())) {
            $product = \Yii::$app->request->post('product_id');
            $product_name = \Yii::$app->request->post('product_name');
            $line_qty = \Yii::$app->request->post('line_qty');
            $line_price = \Yii::$app->request->post('line_price');
            $line_total = \Yii::$app->request->post('line_total');
           // print_r($product);
          //  print_r($line_qty);return;

            $model->status = 1;
            $model->purch_date = date('Y-m-d',strtotime($model->purch_date));
            if($model->save(false)){
                if(count($product)>0){
                    $total_qty = 0;
                    for($i=0;$i<=count($product)-1;$i++){
                        $modelline = new \backend\models\Purchline();
                        $modelline->purch_id = $model->id;
                        $modelline->product_id = $product[$i];
                        $modelline->qty = (float)$line_qty[$i];
                        $modelline->price = (float)$line_price[$i];
                        $modelline->line_amount = (float)$line_total[$i];
                        $modelline->status = 1;
                        $modelline->remain_qty = (float)$line_qty[$i];
                        $modelline->save(false);

                        $total_qty = $total_qty + (float)$line_qty[$i];
                    }
                }
                $this->updateMainqty($model->id,$total_qty);
                $session = Yii::$app->session;
                $session->setFlash('msg','บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'runno'=> $model::getLastNo(1),
        ]);
    }

    /**
     * Updates an existing Purch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelline = \backend\models\Purchline::find()->where(['purch_id'=>$id])->all();

        if ($model->load(Yii::$app->request->post())) {
            $product = \Yii::$app->request->post('product_id');
            $product_name = \Yii::$app->request->post('product_name');
            $line_qty = \Yii::$app->request->post('line_qty');
            $line_price = \Yii::$app->request->post('line_price');
            $line_total = \Yii::$app->request->post('line_total');
            $model->purch_date = date('Y-m-d',strtotime($model->purch_date));
            if($model->save(false)){
                if(count($product)>0){
                    $total_qty = 0;
                    for($i=0;$i<=count($product)-1;$i++){
                        $modelchk = \backend\models\Purchline::find()->where(['purch_id'=>$model->id,'product_id'=>$product[$i]])->one();
                        if($modelchk){
                            $modelchk->qty = (float)$line_qty[$i];
                            $modelchk->price = (float)$line_price[$i];
                            $modelchk->line_amount = (float)$line_total[$i];
                            $modelchk->status = 1;
                            $modelchk->save(false);

                        }else{
                            $modelline = new \backend\models\Purchline();
                            $modelline->purch_id = $model->id;
                            $modelline->product_id = $product[$i];
                            $modelline->qty = (float)$line_qty[$i];
                            $modelline->price = (float)$line_price[$i];
                            $modelline->line_amount = (float)$line_total[$i];
                            $modelline->status = 1;
                            $modelline->save(false);

                        }
                       $total_qty = $total_qty + (float)$line_qty[$i];
                    }
                }
                $this->updateMainqty($id,$total_qty);

                $session = Yii::$app->session;
                $session->setFlash('msg','บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelline'=>$modelline,
        ]);
    }
    public function updateMainqty($id,$qty){
        $model = \backend\models\Purch::find()->where(['id'=>$id])->one();
        if($model){
            $model->purch_total = $qty;
            $model->save(false);
        }
        return true;
    }

    /**
     * Deletes an existing Purch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(\backend\models\Purchline::deleteAll(['purch_id'=>$id])){
            $this->findModel($id)->delete();

            $session = Yii::$app->session;
            $session->setFlash('msg','ลบรายการเรียบร้อย');
            return $this->redirect(['index']);
        }

    }

    /**
     * Finds the Purch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Purch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Purch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionFinditem(){
       $txt = \Yii::$app->request->post('txt');
       $list = [];
       if($txt == ''){
           return Json::encode($list);
           //return 'no';
       }else{
          $model = \backend\models\Product::find()->where(['Like','product_code',$txt])
                                                  ->orFilterWhere(['like','name',$txt])
                                                  ->asArray()
                                                  ->all();
          return Json::encode($model);
       }

    }
    public function actionFinditemfull(){
        $txt = \Yii::$app->request->post('txt');
        $list = [];
        if($txt == ''){
            return Json::encode($list);
            //return 'no';
        }else{
            $list = [];
            $maxprice = 0;
            $model = \backend\models\Product::find()->where(['product_code'=>$txt])->one();
            if($model){
              $model_max_price = \backend\models\Productstockprice::find()->where(['product_id'=>$model->id])->orderBy(['price'=>SORT_DESC])->one();
              if($model_max_price){
                  $maxprice = $model_max_price->price;
              }
              array_push($list,['product_id'=>$model->id,'name'=>$model->name,'maxprice'=>$maxprice]);
            }
            return Json::encode($list);
        }

    }
    public function actionGetlist(){
        $poid = \Yii::$app->request->post('purchid');
      //  return $poid;
        $list = [];
        if($poid == ''){
            return Json::encode($list);
            //return 'no';
        }else{
            $model = \backend\models\Purchline::find()->select(['purch_line.product_id','purch_line.id','purch_line.qty','purch_line.purch_id','purch_line.remain_qty','product.name','product.product_code'])
                ->innerJoin('product','product.id = purch_line.product_id')
                ->where(['purch_line.purch_id'=>$poid])
                ->asArray()
                ->all();
            return Json::encode($model);
        }

    }
    public function actionPurchrec(){
        $poid = \Yii::$app->request->post('poid');
        $prodid = \Yii::$app->request->post('productid');
        $qty = \Yii::$app->request->post('qty');
        if(count($poid)>0){
            $data = [];

            for($i=0;$i<=count($poid)-1;$i++){
                $price = $this->findLinePrice($poid[$i],$prodid[$i]);
                array_push($data,['product_id'=>$prodid[$i],'warehouse_id'=>1,'qty'=>$qty[$i],'line_price'=>$price,'stock_line_type'=>1]);
            }
           $res = Journal::createTrans(\backend\helpers\StockType::TYPE_IN,$data,$poid[0],\backend\helpers\JournalType::TYPE_PO);
              if($res){
                  $this->updatePoStatus($poid[0]);
                 // return Json::encode(['status'=>1]);
                  $session = Yii::$app->session;
                  $session->setFlash('msg','บันทึกรายการเรียบร้อย');
                  return $this->redirect(['index']);
              }
        }
    }

    public function findLinePrice($id,$prodid){
        $line_price = 0;
        $model = \backend\models\Purchline::find()->where(['purch_id'=>$id,'product_id'=>$prodid])->one();
        if($model){
            $line_price = $model->price;
        }
        return $line_price;
    }
    public function updatePoStatus($id){
        $order_qty = 0;
        $modelpurch = \backend\models\Purch::find()->where(['id'=>$id])->one();
        if($modelpurch){
            $order_qty = $modelpurch->purch_total;

            $model = \backend\models\Purchline::find()->where(['purch_id'=>$id])->sum('remain_qty');
            if($model <= 0){
                $modelpurch->status = 2;
                $modelpurch->save();
            }
        }

    }
    public function updateProductprice($vendorid,$productid,$price){
        $model = \backend\models\ProductPrice::find()->where(['product_id'=>$productid,'vendor_id'=>$vendorid])->one();
        if($model){
            $model->price = $price;
            $model->save(false);
        }
    }

}
