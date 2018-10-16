<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','resetpassword'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->updateLoan(); //เกิน
        $this->notifyLoan(1); // 7 วัน
        $this->notifyLoan(2); // 7 วัน กรณีเลื่อน

//        $date1 = date('d-m-Y',1541782800);
//        $date2 =date('d-m-Y');
//        $daycount = $date1 - $date2;
//        echo $daycount;return;

        $cust_count = \backend\models\Customer::find()->count();
        $product_count = \backend\models\Product::find()->count();
        $todays = strtotime(date('d-m-Y'));
        $cur_month = date('m');

        $over_due_count = \backend\models\Loan::find()->where(['<','next_pay_date',$todays])->count();
        $due_count = 0;

        $sql = "SELECT count(id) as count FROM loan WHERE MONTH(DATE(FROM_UNIXTIME(loan.next_pay_date))) = 9";
        $due_count = Yii::$app->db->createCommand($sql)->queryAll();
     //   print_r($due_count);return;
        return $this->render('index',[
            'cust_count'=>$cust_count,
            'product_count'=>$product_count,
            'over_due_count'=>$over_due_count,
            'due_count'=>$due_count[0]['count'],
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = false;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('page-login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    public function createAppNotify($title,$data,$refid){
        if($title !=''){
            $model = new \backend\models\Message();
            $model->title = 'แจ้งเตือน ';
            $model->detail = $data;
            $model->message_type = $title; // 1 แจ้งเตือน
            $model->status = 1;
            //$model->loan_id = $refid;
            if($model->save()){
                return true;
            }else{
                return false;
            }
        }
    }
    public function updateLoan(){
        $todays = strtotime(date('d-m-Y'));
        $model = \backend\models\Loan::find()->where(['<','next_pay_date',$todays])->all();
        $list = [];
        if($model){
            foreach($model as $value){
               array_push($list,[
                   'loan_id'=>$value->id,
                   'code'=>\backend\models\Customer::findCode($value->personal_id),
                   'name'=>\backend\models\Customer::findName($value->personal_id),
                   'next_pay_date'=>$value->next_pay_date,
                   'pay_amount'=>$value->payment_per
               ]);
            }
        }
        if(count($list)>0){

            $days = (date('d-m-Y',$list[0]['next_pay_date'])-date('d-m-Y'));


            $message = 'ลูกค้า '.$list[0]['code']." ".$list[0]['name']."\n"
                .' กำหนดชำระวันที่ '.date('d-m-Y',$list[0]['next_pay_date'])."\n"
                .' ยอดที่ต้องชำระ '.number_format($list[0]['pay_amount'],0)."\n"
                .' เกินกำหนดชำระ '. abs($days)  ." วัน"."\n"
                .' เบอรโทร '. \backend\models\Customer::findPhone($list[0]['code']);

            if($days <0){
                $this->createAppNotify(\backend\helpers\MessageType::TYPE_OVER,$message,1);
            }

            $line_api = 'https://notify-api.line.me/api/notify';
            $line_token = 'xo5naiFLvPc02gPcRZp1eK2ChI9NH0pn0qFEG2aR4qj'; // the first

            header('Content-Type: text/html; charset=utf-8');

            $queryData = array('message' => $message);
            $queryData = http_build_query($queryData, '', '&');
            $headerOptions = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                        . "Authorization: Bearer " . $line_token . "\r\n"
                        . "Content-Length: " . strlen($queryData) . "\r\n",
                    'content' => $queryData
                )
            );
            $context = stream_context_create($headerOptions);
            $result = file_get_contents($line_api, FALSE, $context);
            $res = json_decode($result);
            return $res;
        }

    }
    public function notifyLoan($daytype){
        $todays = strtotime(date('d-m-Y'));
        if($daytype == 1){
            $model = \backend\models\Loan::find()->where(['>','next_pay_date',$todays])->all();
        }else{
            $model = \backend\models\Loan::find()->where(['>','append_date',$todays])->all();
        }

        $list = [];
        if($model){
            $date1 = "";
            $date2 ="";
            foreach($model as $value){
                if($daytype == 1){
                    $date1 = date('d-m-Y',$model->next_pay_date);
                }else{
                    if(!empty($model->append_date)){
                        $date1 = date('d-m-Y',$model->append_date);
                    }

                }

                $date2 =date('d-m-Y');
                $daycount = ($date1 - $date2);

                if($daycount < 7){
                    array_push($list,[
                        'loan_id'=>$value->id,
                        'code'=>\backend\models\Customer::findCode($value->personal_id),
                        'name'=>\backend\models\Customer::findName($value->personal_id),
                        'next_pay_date'=>$daytype == 1?$value->next_pay_date:$value->append_date,
                        'pay_amount'=>$value->payment_per,

                    ]);
                }

            }
        }
        if(count($list)>0){

            $days = (date('d-m-Y',$list[0]['next_pay_date'])-date('d-m-Y'));


            $message = 'ลูกค้า '.$list[0]['code']." ".$list[0]['name']."\n"
                .' กำหนดชำระวันที่ '. "<b>".date('d-m-Y',$list[0]['next_pay_date'])."</b>"."\n"
                .' ยอดที่ต้องชำระ '.number_format($list[0]['pay_amount'],0)."\n"
                .' ต้องชำระในอีก '. "<b>".abs($days)  ." วัน"."</b>";
            $message_line = 'ลูกค้า '.$list[0]['code']." ".$list[0]['name']."\n"
                .' กำหนดชำระวันที่ '.date('d-m-Y',$list[0]['next_pay_date'])."\n"
                .' ยอดที่ต้องชำระ '.number_format($list[0]['pay_amount'],0)."\n"
                .' ต้องชำระในอีก '.abs($days)  ." วัน"."\n"
                .' เบอรโทร '. \backend\models\Customer::findPhone($list[0]['code']);

            if($days >0){
                $this->createAppNotify(\backend\helpers\MessageType::TYPE_NEAR,$message,1);
            }
            $line_api = 'https://notify-api.line.me/api/notify';
            $line_token = 'xo5naiFLvPc02gPcRZp1eK2ChI9NH0pn0qFEG2aR4qj'; // the first

            header('Content-Type: text/html; charset=utf-8');

            $queryData = array('message' => $message_line);
            $queryData = http_build_query($queryData, '', '&');
            $headerOptions = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                        . "Authorization: Bearer " . $line_token . "\r\n"
                        . "Content-Length: " . strlen($queryData) . "\r\n",
                    'content' => $queryData
                )
            );
            $context = stream_context_create($headerOptions);
            $result = file_get_contents($line_api, FALSE, $context);
            $res = json_decode($result);
            return $res;
        }

    }
    public function checkdupmessage($loanid){

    }
    public function actionResetpassword(){
        $model=new \backend\models\Resetform();
        if($model->load(Yii::$app->request->post())){
            $model_user = \backend\models\User::find()->where(['id'=>Yii::$app->user->id])->one();
            $model_user->setPassword($model->confirmpw);
            $model_user->save();
            return $this->redirect(['site/index']);
        }
        return $this->render('_setpassword',[
            'model'=>$model
        ]);
    }
}
