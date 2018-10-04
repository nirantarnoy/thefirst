<?php

namespace backend\controllers;

use backend\models\Loanpayment;
use Yii;
use backend\models\Loan;
use backend\models\LoanSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LoanController implements the CRUD actions for Loan model.
 */
class LoanController extends Controller
{
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
     * Lists all Loan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new LoanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Loan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new \backend\models\LoanpaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['loan_id'=>$id]);
        $dataProvider->setSort(['defaultOrder'=>['created_at'=>SORT_DESC]]);

        $model = \backend\models\Loan::find()->where(['id'=>$id])->one();
        $findnext = \backend\models\Loanpayment::find()->where(['loan_id'=>$id])->one();

        $next_pay = '';

        $last_pay = \backend\models\Loanpayment::find()->where(['loan_id'=>$id])->max('created_at');


        if($findnext){
            $next_pay = $model->next_pay_date;
        }else{
            $next_pay = $model->first_pay_date;
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider'=> $dataProvider,
            'next_pay' => $next_pay,
            'last_pay' => $last_pay,
        ]);
    }

    /**
     * Creates a new Loan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Loan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Loan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Loan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Loan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Loan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Loan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionPayment(){
        $id = \Yii::$app->request->post('loanid');
        if($id){
            $list = [];
            $model = \backend\models\Loan::find()->where(['id'=>$id])->one();
            if($model)
            {
                $modelline_cnt = \backend\models\Loanpayment::find()->where(['loan_id'=>$id])->count();
                array_push($list,['loan_no'=>$model->loan_no,
                                         'pay_time'=>($modelline_cnt +1).'/'.$model->period,
                                         'must_pay_day'=>date('d-m-Y',$model->next_pay_date),
                                            'pay_per'=>$model->payment_per,
                                            'pay_per_day'=>$model->fee_rate,
                                            'pay_ever_day'=>$model->pay_ever_day]);
            }
            return Json::encode($list);
        }
    }
    public function actionPaymentsubmit(){
        $id = \Yii::$app->request->post('loanid');
        $payamount =\Yii::$app->request->post('payamt');
        $fine = \Yii::$app->request->post('fine');
        $note = \Yii::$app->request->post('note');
        $periodof = \Yii::$app->request->post('peroidof');

        if($id != ""){
           // $modelline_cnt = \backend\models\Loanpayment::find()->where(['loan_id'=>$id])->count();

            $model = new \backend\models\Loanpayment();
            $model->loan_id = $id;
            $model->amount = $payamount;
            $model->fine = $fine;
            $model->note = $note;
            $model->periodof = $periodof;
            $model->payment_date = strtotime(date('d-m-Y H:i:s'));
            $model->status = 1;
            $model->save(false);
           // return Json::encode([1]);
            $this->updateLoan($id);
            $session = Yii::$app->session;
            $session->setFlash('msg','บันทึกรายการเรียบร้อย');
            return $this->redirect(['index']);
        }
    }
    public function updateLoan($id){
        $modelline_cnt = \backend\models\Loanpayment::find()->where(['loan_id'=>$id])->count();
        $model = \backend\models\Loan::find()->where(['id'=>$id])->one();
        $nextdate = '';

        $oldnext = $model->next_pay_date;
        $nextdate = date('d-m-Y',strtotime("+30 days"));

        if($modelline_cnt == $model->period){
            $model->status = 2;
            $model->next_pay_date = strtotime($nextdate) ;
            $model->save(false);
        }else{
            $model->status = 1;
            $model->next_pay_date = strtotime($nextdate) ;
            $model->save(false);
        }

    }
    public function actionCalendaritem($start=NULL,$end=NULL,$_=NULL){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // $times = \app\modules\timetrack\models\Timetable::find()->where(array('category'=>\app\modules\timetrack\models\Timetable::CAT_TIMETRACK))->all();
        $times = \common\models\Event::find()->all();
        // $times = \common\models\PurchPlan::find()->all();
        $events = [];

        foreach ($times AS $time){
            //Testing
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $time->id;
            $Event->title = $time->title;
            //  $Event->start = date('Y-m-d\TH:i:s\Z');
            $Event->start = date('Y-m-d',strtotime($time->trans_date));
            // $Event->end = date('Y-m-d\TH:i:s\Z',strtotime($time->end.' '.$time->end));
            $Event->backgroundColor = "green";
            $events[] = $Event;
        }

        return $events;
    }
    public function actionCreatetitle(){
        $model = new \common\models\Event();
        if($model->load(Yii::$app->request->post())){
            //  echo Yii::$app->request->post('plan_date');return;
            $pdate = date_create(Yii::$app->request->post('plan_date'));
            //echo date_format($pdate,'d-m-Y');return;
            $model->start = strtotime(date_format($pdate,'d-m-Y'));
            if($model->save()){
                return $this->redirect(['index']);
            }
        }
    }
    public function actionShowcalendar(){
        $modelevent = new \common\models\Event();
        return $this->render('_plancalendar',['modelevent'=>$modelevent,]);
    }
    public function createEvent($date,$title){
        \backend\models\Event::deleteAll(['title'=>$title]);
        if($date !=''){
            $model = new \backend\models\Event();
            $model->title = $title;
            $model->start = strtotime($date);
            $model->trans_date = $date;
            if($model->save(false)){
                return true;
            }
            return false;
        }
    }
    public function actionFindevent(){
        $datefind = Yii::$app->request->post('datefind');
        // return strtotime($datefind ."+1 days");
        $times = date('Y-m-d',strtotime($datefind));
        // return $times;
        // return date('d-m-Y',$times);
        if($datefind !='') {

//            $sql = "SELECT plan_type,SUM(plan_qty)as qty FROM purch_plan_line WHERE trans_date = '$times'  GROUP BY plan_type";
//            $query = Yii::$app->db->createCommand($sql)->queryAll();
            $data = [];
//            for ($i = 0; $i < sizeof($query); $i++) {
//                array_push($data, ['no' => $i + 1, 'product' => \backend\models\Product::findName($query[$i]['plan_type']), 'qty' => number_format($query[$i]['qty'])]);
//            }

       //     $modelwork = \backend\models\Workschedule::find()->where(['trans_date' => $times])->one();
            $data2 = [];
//            if($modelwork){
//                array_push($data2, ['no' => 1, 'orchard' => \backend\models\Orchard::getName($modelwork->orchard_id),
//                    'team_cut' => \backend\models\Team::findName($modelwork->team_cut),
//                    'team_pick'=> \backend\models\Team::findName($modelwork->team_pick)]);
//            }
            $x=[];
            $m=[];
            $xdata = [];
//            array_push($x,['name'=>'niran']);
//            array_push($m,['name'=>'tarlek']);
            // return Json::encode($data);
            $xdata[0]= $data;
            $xdata[1]= $data2;
            return Json::encode($xdata);
        }
    }
    public function actionPostpone(){
       $loanid = \Yii::$app->request->post("loanid");
       $app_date = \Yii::$app->request->post('postpone_date');
       if($loanid){
           $model = \backend\models\Loan::find()->where(['id'=>$loanid])->one();
           if($model){
               $model->append_date = strtotime($app_date);
               $model->status = 3; // postpone
               if($model->save(false)){
                   $session = Yii::$app->session;
                   $session->setFlash('msg','บันทึกรายการเรียบร้อย');
                   return $this->redirect(['index']);
               }

           }
       }
    }

}
