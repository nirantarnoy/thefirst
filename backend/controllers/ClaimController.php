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
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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

            if($model->save()){
                if(count($product) > 0){
                    for($i=0;$i<=count($product)-1;$i++){
                        $modelline = new \common\models\ClaimLine();
                        $modelline->claim_id = $model->id;
                        $modelline->product_id = $product[$i];
                        $modelline->problem = $line_cause[$i];
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
                        array_push($list,['sale_id'=>$value->sale_id,'product_id'=>$value->product_id,
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
}
