<?php

namespace backend\controllers;

use Yii;
use backend\models\Claim;
use backend\models\ClaimSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * ClaimController implements the CRUD actions for Claim model.
 */
class ClaimController extends Controller
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
     * Lists all Claim models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new ClaimSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage'=>$pageSize,
        ]);
    }

    /**
     * Displays a single Claim model.
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
     * Creates a new Claim model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Claim();

        if ($model->load(Yii::$app->request->post())) {

            $product = \Yii::$app->request->post('product_id');
            $product_name = \Yii::$app->request->post('product_name');
            $line_qty = \Yii::$app->request->post('line_qty');
            $line_cause = \Yii::$app->request->post('line_cause');
            $line_ref = \Yii::$app->request->post('line_ref');

            $model->trans_date = strtotime($model->trans_date);
            $model->status = 1;

            if($model->save()){
                if(count($product) > 0){
                    for($i=0;$i<=count($product)-1;$i++){
                        $modelline = new \backend\models\Claimline();
                        $modelline->claim_id = $model->id;
                        $modelline->product_id = $product[$i];
                        $modelline->problem = $line_cause[$i];
                        $modelline->qty = $line_qty[$i];
                        $modelline->sale_ref = $line_ref[$i];
                        $modelline->status = 1;
                        $modelline->save();
                    }
                }
            }

            $session = Yii::$app->session;
            $session->setFlash('msg','บันทึกรายการเรียบร้อย');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'runno' => $model->getLastNo(),
        ]);
    }

    /**
     * Updates an existing Claim model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelline = \backend\models\Claimline::find()->where(['claim_id'=>$id])->all();

        if ($model->load(Yii::$app->request->post()) ) {

            $product = \Yii::$app->request->post('product_id');
            $product_name = \Yii::$app->request->post('product_name');
            $line_qty = \Yii::$app->request->post('line_qty');
            $line_cause = \Yii::$app->request->post('line_cause');
            $line_ref = \Yii::$app->request->post('line_ref');

            $model->trans_date = strtotime($model->trans_date);
            $model->status == 1;

            if($model->save()){
                if(count($product) > 0){
                    \backend\models\Claimline::deleteAll(['claim_id'=>$id]);
                    for($i=0;$i<=count($product)-1;$i++){
                        $modelline = new \backend\models\Claimline();
                        $modelline->claim_id = $model->id;
                        $modelline->product_id = $product[$i];
                        $modelline->problem = $line_cause[$i];
                        $modelline->qty = $line_qty[$i];
                        $modelline->sale_ref = $line_ref[$i];
                        $modelline->status = 1;
                        $modelline->save();
                    }
                }
            }

            $session = Yii::$app->session;
            $session->setFlash('msg','บันทึกรายการเรียบร้อย');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'modelline' => $modelline,
        ]);
    }

    /**
     * Deletes an existing Claim model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(\common\models\ClaimLine::deleteAll(['claim_id'=>$id])){
            $this->findModel($id)->delete();

            $session = Yii::$app->session;
            $session->setFlash('msg','ลบรายการเรียบร้อย');
            return $this->redirect(['index']);
        }else{
            $this->findModel($id)->delete();

            $session = Yii::$app->session;
            $session->setFlash('msg','ลบรายการเรียบร้อย');
            return $this->redirect(['index']);
        }


    }

    /**
     * Finds the Claim model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Claim the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Claim::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionFindso(){
        $so = Yii::$app->request->post("so");
        $list = [];
        if($so){
            $model = \backend\models\Sale::find()->where(['sale_no'=>$so])->one();
            if($model){
                $modelline = \backend\models\Saleline::find()->select(['sale_id','product_id','qty'])->where(['sale_id'=>$model->id])->all();
                if($modelline){
                    foreach ($modelline as $value){
                        array_push($list,[
                                                 'sale_id'=>$value->sale_id,
                                                 'product_id'=>$value->product_id,
                                                 'product_code'=>\backend\models\Product::findProductcode($value->product_id),
                                                 'name'=>\backend\models\Product::findName($value->product_id),
                                                 'qty'=>$value->qty]);
                    }

                    return Json::encode($list);
                }else{
                    return Json::encode($list);
                }
            }else{
                return Json::encode($list);
            }
        }
    }
    public function actionConfirmclaim(){
        $id = \Yii::$app->request->post("id");
        if($id){
            $modelline = \backend\models\Claimline::find()->where(['claim_id'=>$id])->all();
            if($modelline){
                $data = [];
                foreach ($modelline as $value){
                    array_push($data,['product_id'=>$value->product_id,'warehouse_id'=>1,'qty'=>$value->qty,'line_price'=>0,'stock_line_type'=>1]);
                }
                $res = \backend\models\Journal::createTrans(\backend\helpers\StockType::TYPE_IN,$data,$id,\backend\helpers\JournalType::TYPE_CLAIM);
                if($res){
                    $this->updateClaim($id);
                    $session = Yii::$app->session;
                    $session->setFlash('msg','ทำรายการเรียบร้อย');
                    return $this->redirect(['index']);
                }
            }
        }
    }
    public function updateClaim($id){
        $model = \backend\models\Claim::find()->where(['id'=>$id])->one();
        if($model){
            $model->status = 2;
            $model->save();
        }
    }
}
