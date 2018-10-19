<?php

namespace backend\controllers;

use Yii;
use backend\models\Sale;
use backend\models\SaleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

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
                    $total_sale = 0;
                    for($i=0;$i<=count($product)-1;$i++){
                        $total_sale = $total_sale + (float)$line_total[$i];
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
                $modelupdate_total = \backend\models\Sale::find()->where(['id'=>$model->id])->one();
                $modelupdate_total->sale_total = $total_sale;
                $modelupdate_total->sale_total_text = $this->numtothai($total_sale);
                $modelupdate_total->save();

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
                    $total_sale = 0;
                    \backend\models\Saleline::deleteAll(['sale_id'=>$model->id]);
                    for($i=0;$i<=count($product)-1;$i++){

                        $total_sale = $total_sale + (float)$line_total[$i];
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
                $modelupdate_total = \backend\models\Sale::find()->where(['id'=>$model->id])->one();
                $modelupdate_total->sale_total = $total_sale;
                $modelupdate_total->sale_total_text = $this->numtothai((float)$total_sale);
                $modelupdate_total->save();

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
    public function actionPrintbill(){
        $id = \Yii::$app->request->post("id");
        $papersize = Yii::$app->request->post('paper_size');
        if($id){
          //  return $papersize;
            $model = \backend\models\Sale::find()->where(['id'=>$id])->one();
            $bill_total = 0;
            if($model){
                $shop = \backend\models\Plant::find()->one();
               // $modeladdress = \backend\models\AddressBook::find()->where(['party_id'=>1])->one();
                $modeladdress = \backend\models\AddressBook::findAddress($model->customer_id);
                $modelline = \backend\models\Saleline::find()->where(['sale_id'=>$id])->all();

                if($modelline){
                    foreach($modelline as $val){
                        $bill_total = $bill_total + $val->line_total;
                    }
                }


                $custname = '';
                $modelcust = \backend\models\Customer::find()->where(['id'=>$model->customer_id])->one();
                if($modelcust){
                    $custname = $modelcust->first_name;
                }

                $pdf = new Pdf([
                    'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                    //  'format' => [150,236], //manaul
                    'format' => $papersize ==1? Pdf::FORMAT_A4:[140,210],
                    //'format' =>  Pdf::FORMAT_A5,
                    'orientation' => $papersize ==1?Pdf::ORIENT_PORTRAIT: Pdf::ORIENT_LANDSCAPE,
                    'destination' => Pdf::DEST_BROWSER,
                    'content' => $this->renderPartial('_bill',[
                        'model'=>$model,
                        'shop'=>$shop,
                        'modelline'=>$modelline,
                        'modeladdress'=>$modeladdress,
                        'custname'=>$custname,
                        'bill_date'=>date('d-m-Y'),
                        'bill_total' => $bill_total,

                    ]),
                    //'content' => "nira",
                   // 'defaultFont' => '@backend/web/fonts/config.php',
                    'cssFile' => '@backend/web/css/pdf.css',
                    'options' => [
                        'title' => 'ใบเสร็จ',
                        'subject' => ''
                    ],
                    'methods' => [
                        //  'SetHeader' => ['รายงานรหัสสินค้า||Generated On: ' . date("r")],
                        //  'SetFooter' => ['|Page {PAGENO}|'],
                        //'SetFooter'=>'niran',
                    ],

                ]);
                //return $this->redirect(['genbill']);
                Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
                Yii::$app->response->headers->add('Content-Type', 'application/pdf');
                return $pdf->render();

            }
        }
    }
    public function numtothaistring($num)
    {
        $return_str = "";
        $txtnum1 = array('','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า');
        $txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
        $num_arr = str_split($num);
        $count = count($num_arr);
        foreach($num_arr as $key=>$val)
        {
            // echo $count." ".$val." ".$key."</br>";
            if($count > 1 && $val == 1 && $key ==($count-1)) {
                $return_str .= "เอ็ด";
            }else if($count > 1 && $val == 1 && $key == 2) {
                $return_str .= $txtnum2[$val];
            }else if($count > 1 && $val == 2 && $key ==($count-2)){
                $return_str .="ยี่".$txtnum2[$count-$key-1];
            }else if($count > 1 && $val ==0){}
            else{
                $return_str .= $txtnum1[$val].$txtnum2[$count-$key-1];
            }

        }
        return $return_str ;
    }
    public function numtothai($num)
    {
        $return = "";
        $num = str_replace(",","",$num);
        $number = explode(".",$num);
        if(sizeof($number)>2){
            return 'รูปแบบข้อมุลไม่ถูกต้อง';
            exit;
        }else if(sizeof($number)==1){
            $number[1]=0;
        }
        // return $number[0];
        $return .= $this->numtothaistring($number[0])."บาท";

        $stang = intval($number[1]);
        // return $stang;
        if($stang > 0)
            $return.= $this->numtothaistring($stang)."สตางค์";
        else
            $return .= "ถ้วน";
        return $return ;
    }
    public function actionFindmaxprice(){
        $id = \Yii::$app->request->post("prodid");
       // return $id;
        if($id){

            $model = \backend\models\Productstockprice::find()->where(['product_id'=>$id])->orderBy(['price'=>SORT_DESC])->one();
            if($model){
                return $model->price;
            }
            return 0;
        }
        return 0;
    }
}
