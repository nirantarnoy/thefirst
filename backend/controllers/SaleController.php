<?php

namespace backend\controllers;

use Yii;
use backend\models\Sale;
use backend\models\SaleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * SaleController implements the CRUD actions for Sale model.
 */
class SaleController extends Controller
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
        ];
    }

    /**
     * Lists all Sale models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new SaleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Sale model.
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
     * Creates a new Sale model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sale();

        if ($model->load(Yii::$app->request->post())) {

            $product = \Yii::$app->request->post('product_id');
            $product_name = \Yii::$app->request->post('product_name');
            $line_qty = \Yii::$app->request->post('line_qty');
            $line_price = \Yii::$app->request->post('line_price');
            $line_total = \Yii::$app->request->post('line_total');

            $model->trans_date = strtotime($model->trans_date);
            $model->status = 1;
            if($model->save()){
                if(count($product)>0){
                    for($i=0;$i<=count($product)-1;$i++){
                        $modelline = new \backend\models\Saleline();
                        $modelline->sale_id = $model->id;
                        $modelline->product_id = $product[$i];
                        $modelline->qty = (float)$line_qty[$i];
                        $modelline->price = (float)$line_price[$i];
                        $modelline->line_total = (float)$line_total[$i];
                        $modelline->status = 1;
                        $modelline->save(false);
                    }
                }
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
     * Updates an existing Sale model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelline = \backend\models\Saleline::find()->where(['sale_id'=>$id])->all();

        if ($model->load(Yii::$app->request->post())) {
            $product = \Yii::$app->request->post('product_id');
            $product_name = \Yii::$app->request->post('product_name');
            $line_qty = \Yii::$app->request->post('line_qty');
            $line_price = \Yii::$app->request->post('line_price');
            $line_total = \Yii::$app->request->post('line_total');

            $model->trans_date = strtotime($model->trans_date);
            if($model->save()){
                if(count($product)>0){
                    \backend\models\Saleline::deleteAll(['sale_id'=>$model->id]);
                    for($i=0;$i<=count($product)-1;$i++){
                        $modelchk = \backend\models\Saleline::find()->where(['sale_id'=>$model->id,'product_id'=>$product[$i]])->one();
                        if($modelchk){
                            $modelchk->qty = (float)$line_qty[$i];
                            $modelchk->price = (float)$line_price[$i];
                            $modelchk->line_total = (float)$line_total[$i];
                            $modelchk->status = 1;
                            $modelchk->save(false);

                        }else{
                            $modelline = new \backend\models\Saleline();
                            $modelline->sale_id = $model->id;
                            $modelline->product_id = $product[$i];
                            $modelline->qty = (float)$line_qty[$i];
                            $modelline->price = (float)$line_price[$i];
                            $modelline->line_total = (float)$line_total[$i];
                            $modelline->status = 1;
                            $modelline->save(false);

                        }

                    }
                }
                $session = Yii::$app->session;
                $session->setFlash('msg','บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelline' =>$modelline,
        ]);
    }

    /**
     * Deletes an existing Sale model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(\backend\models\Saleline::deleteAll(['sale_id'=>$id]))
        {
            $this->findModel($id)->delete();

            $session = Yii::$app->session;
            $session->setFlash('msg','ลบข้อมูลเรียบร้อยแล้ว');
            return $this->redirect(['index']);
        }

    }

    /**
     * Finds the Sale model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sale the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sale::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionLoan(){
        $saleid = \Yii::$app->request->post('saleid');
        $allperiod = \Yii::$app->request->post('allperiod');
        $loanper = \Yii::$app->request->post('loanper');
        $perqty = \Yii::$app->request->post('perqty');
        $payday = \Yii::$app->request->post('payday');
        $feerate = \Yii::$app->request->post('feerate');
        $sdate = \Yii::$app->request->post('sdate');
        $ndate = \Yii::$app->request->post('ndate');

        $enddate = date_create($ndate);

        $model = \backend\models\Loan::find()->where(['sale_id'=>$saleid])->one();
        if($model){
            $model->period = $allperiod;
            $model->payment_per = $perqty;
            $model->loan_percent = $loanper;
            $model->pay_ever_day = $payday;
            $model->fee_rate = $feerate;
            $model->first_pay_date = strtotime($sdate);
            $model->end_pay_date = date('Y-m-d',$enddate);
            $model->save(false);
        }else{
            $model = new \backend\models\Loan();
            $model->loan_no = \backend\models\Loan::getLastNo();
            $model->sale_id = $saleid;
            $model->status = 1;
            $model->period = $allperiod;
            $model->personal_id = $this->findCustinfo($saleid);
            $model->payment_per = $perqty;
            $model->loan_percent = $loanper;
            $model->pay_ever_day = $payday;
            $model->fee_rate = $feerate;
            $model->first_pay_date = strtotime($sdate);
         //   $model->end_pay_date = date('Y-m-d',$ndate);
            $model->save(false);
        }


        $session = Yii::$app->session;
        $session->setFlash('msg','ลบข้อมูลเรียบร้อยแล้ว');
        return $this->redirect(['index']);
    }
    public function actionFindloan(){
        $saleid = \Yii::$app->request->post('saleid');
        $model = \backend\models\Loan::find()->where(['sale_id'=>$saleid])->asArray()->one();
        $list = [];
        if($model){
            return Json::encode($model);
        }else{
            return Json::encode($list);
        }

    }
    public function findCustinfo($saleid){
        $model = \backend\models\Sale::find()->where(['id'=>$saleid])->one();
        if($model){
            return $model->customer_id;
        }else{
            return 0;
        }
    }
    public function actionConfirmsale(){
       $saleid = \Yii::$app->request->post("saleid");
       if($saleid){
           $modelline = \backend\models\Saleline::find()->where(['sale_id'=>$saleid])->all();
           if($modelline){
               $data = [];
               foreach ($modelline as $value){
                   array_push($data,['product_id'=>$value->product_id,'warehouse_id'=>1,'qty'=>$value->qty,'line_price'=>$value->price,'stock_line_type'=>2]);
               }
               $res = \backend\models\Journal::createTrans(\backend\helpers\StockType::TYPE_OUT,$data,$saleid,\backend\helpers\JournalType::TYPE_SO);
               if($res){
                   $this->updateSo($saleid);
                   $session = Yii::$app->session;
                   $session->setFlash('msg','ทำรายการเรียบร้อย');
                   return $this->redirect(['index']);
               }
           }
       }
    }
    public function updateSo($id){
        $model = \backend\models\Sale::find()->where(['id'=>$id])->one();
        if($model){
            $model->status = 2;
            $model->save();
        }
    }
}
