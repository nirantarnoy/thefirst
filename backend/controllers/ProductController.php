<?php

namespace backend\controllers;

use backend\models\Uploadfile;
use backend\models\Vendor;
use Yii;
use backend\models\Product;
use backend\models\StockbalanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use backend\helpers\TransType;
use backend\models\TransCalculate;
use yii\filters\AccessControl;
use backend\models\Productpic;
use yii\web\ForbiddenHttpException;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
     public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST','GET'],
                    'findvendor'=>['POST'],
                ],
            ],
//            'access'=>[
//                'class'=>AccessControl::className(),
//                'rules'=>[
//                    [
//                        'allow'=>true,
//                        'actions'=>['index','create','update','delete','view','deletepic','exporttemplate','importproduct','export'],
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $group = [];
        $stockstatus = [];
        $searcname = '';
        if(Yii::$app->request->isPost){
            $group = Yii::$app->request->post('product_group');
            $stockstatus = Yii::$app->request->post('stock_status');
            $searcname = Yii::$app->request->post('search_all');

        }


        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new \backend\models\ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['category_id'=>$group])->andFilterWhere(['OR',['LIKE','product_code',$searcname],['LIKE','name',$searcname]]);
        if(count($stockstatus)>1){
            if(in_array("1",$stockstatus,true) and in_array("2",$stockstatus,true) and in_array("3",$stockstatus,true)){

            }else  if(in_array("1",$stockstatus,true) and in_array("2",$stockstatus,true)){
                $dataProvider->query->andFilterWhere(['>','all_qty',0]);
            }else if(in_array("1",$stockstatus,true) and in_array("3",$stockstatus,true)){
                $dataProvider->query->andFilterWhere(['OR',['AND',['>','all_qty',0],['<=','min_stock','all_qty']],['=','all_qty',0]]);
            }else if(in_array("2",$stockstatus,true) and in_array("3",$stockstatus,true)){
                $dataProvider->query->andFilterWhere(['OR',['>','min_stock','all_qty'],['=','all_qty',0]]);
            }

        }else if(count($stockstatus)>0 and count($stockstatus)<2){
            //echo $stockstatus[0];return;
            if($stockstatus[0] == "1"){
                $dataProvider->query->andFilterWhere(['AND',['>','all_qty',0],['<=','min_stock','all_qty']]);
            }else if($stockstatus[0] == "2"){
                $dataProvider->query->andFilterWhere(['>','min_stock','all_qty']);
            }else if($stockstatus[0] == "3"){
                $dataProvider->query->andFilterWhere(['=','all_qty',0]);
            }
        }


        $dataProvider->pagination->pageSize = $pageSize;
        $modelupload = new \backend\models\Uploadfile();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
            'viewtype' => 'list',
            'modelupload'=> $modelupload,
            'group'=>$group,
            'stockstatus'=> $stockstatus,
            'searchname' => $searcname,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

       // $modeljournalline = \backend\models\Journalline::find()->where(['product_id'=>$id])->all();
      //  $uploadfile = new \backend\models\Uploadfile();

        //echo strtotime(date_format($start,'d-m-Y'));
       // echo strtotime() ."-". strtotime(trim($dt_range[1]));
      //  $movementSearch = new \backend\models\MovementSearch();
      //  $movementDp = $movementSearch->search(Yii::$app->request->queryParams);
       // $movementDp->pagination->pageSize = 10;
       // $movementDp->query->andFilterWhere(['product_id'=>$id]);
//        if(isset(Yii::$app->request->queryParams['MovementSearch']['created_at'])){
//            $dt = Yii::$app->request->queryParams['MovementSearch']['created_at'];
//            $dt_range = explode("to",$dt);
//            $start = date_create(trim($dt_range[0]));
//           // $end = date_create(trim($dt_range[1]));
//           // $movementDp->query->andFilterWhere(['between','created_at',strtotime(date_format($start,'d-m-Y')),strtotime(date_format($end,'d-m-Y'))]);
//
//        }

       // $photoes = \backend\models\Productgallery::find()->where(['product_id'=>$id])->all();

        $searchModel = new StockbalanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['product_id'=>$id]);

        $movementSearch = new \backend\models\MovementSearch();
        $movementDp = $movementSearch->search(Yii::$app->request->queryParams);
        $movementDp->pagination->pageSize = 10;
        $movementDp->query->andFilterWhere(['product_id'=>$id]);


        return $this->render('view', [
            'model' => $this->findModel($id),
           // 'modeljournalline' => $modeljournalline,
          //  'photoes'=>$photoes,
          //  'uploadfile'=>$uploadfile,
          //  'movementDp' => $movementDp,
         //   'movementSearch'=> $movementSearch,
            'dataProvider'=>$dataProvider,
            'movementSearch'=>$movementSearch,
            'movementDp' => $movementDp,

        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $modelfile = new \backend\models\Modelfile();

        if ($model->load(Yii::$app->request->post())) {
            $vendorid = Yii::$app->request->post('vendor_id');
            $price = Yii::$app->request->post('line_price');

            $uploadeds = UploadedFile::getInstances($modelfile,'file');


            if($model->save()){

                if(!empty($uploadeds)){
                    foreach($uploadeds as $file){
                        $file->saveAs(Yii::getAlias('@backend') .'/web/uploads/'.$file);
                        $modelpic = new Productpic();
                        $modelpic->product_id = $model->id;
                        $modelpic->picture = $file->name;
                        $modelpic->save(false);
                    }
                }

                for($i=0;$i<=count($vendorid)-1;$i++){
                    $modelx = new \backend\models\ProductPrice();
                    $modelx->product_id = $model->id;
                    $modelx->vendor_id = $vendorid[$i];
                    $modelx->price = $price[$i];
                    $modelx->status = 1;
                    $modelx->save();
                }
                $session = Yii::$app->session;
                $session->setFlash('msg','บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);
            }

        }

        return $this->render('create', [
            'model' => $model,
            'modelfile'=>$modelfile,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelprice = \backend\models\ProductPrice::find()->where(['product_id'=>$id])->all();
        $modelfile = new \backend\models\Modelfile();
        $modelpic = \backend\models\Productpic::find()->where(['product_id'=>$id])->all();

        if ($model->load(Yii::$app->request->post())) {

            $vendorid = Yii::$app->request->post('vendor_id');
            $price = Yii::$app->request->post('line_price');

            $uploadeds = UploadedFile::getInstances($modelfile,'file');
          //  print_r($vendorid);return;
            if($model->save()){
                if(!empty($uploadeds)){
//                    $modeloldpic = \backend\models\Productpic::find()->where(['product_id'=>$id])->all();
//                    if($modeloldpic) {
//                        foreach ($modeloldpic as $value) {
//                            unlink(Yii::getAlias('@backend') .'/web/uploads/'.$value->picture);
//                        }
//                    }

                    //Productpic::deleteAll(['product_id'=>$model->id]);
                    foreach($uploadeds as $file){
                        $file->saveAs(Yii::getAlias('@backend') .'/web/uploads/'.$file);
                        $modelpic = new Productpic();
                        $modelpic->product_id = $model->id;
                        $modelpic->picture = $file->name;
                        $modelpic->save(false);
                    }
                }
               if(count($vendorid)>0){
                   \backend\models\ProductPrice::deleteAll(['product_id'=>$id]);
                   for($i=0;$i<=count($vendorid)-1;$i++){
                       if($vendorid[$i]==''){continue;}
                       //echo $vendorid[$i];return;
                       $chk = \backend\models\ProductPrice::find()->where(['product_id'=>$id,'vendor_id'=>$vendorid[$i]])->one();

                       if($chk){
                           $chk->price = $price[$i];
                           $chk->status = 1;
                           $chk->save(false);
                       }else{
                           $modelx = new \backend\models\ProductPrice();
                           $modelx->product_id = $model->id;
                           $modelx->vendor_id = $vendorid[$i];
                           $modelx->price = $price[$i];
                           $modelx->status = 1;
                           $modelx->save(false);
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
            'modelprice'=>$modelprice,
            'modelfile'=>$modelfile,
            'modelpic'=>$modelpic,

        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        $session = Yii::$app->session;
        $session->setFlash('msg','ลบรหัสสินค้าเรียบร้อย');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionExporttemplate(){
        $strExcelFileName="form_product.xls";
        header('Content-Encoding: UTF-8');
        header("Content-Type: application/x-msexcel ; name=\"$strExcelFileName\" charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$strExcelFileName\"");
        header("Content-Transfer-Encoding: binary");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "
           <table border='1'>
             <tr>
                <td>Product Code</td>
                <td>Name</td>
                <td>Category</td>
                <td>Unit</td>
                <td>Qty</td>
                <td>Price</td>
                <td>Cost</td>
            </tr>
            </table>
        ";
    }
    public function actionImportproduct(){

        $model = new \backend\models\Uploadfile();
        if(Yii::$app->request->post()){
            $uploaded = UploadedFile::getInstance($model, 'file');
            if(!empty($uploaded)) {
                $upfiles = time() . "." . $uploaded->getExtension();
                if($uploaded->saveAs(Yii::getAlias('@backend').'/web/uploads/files/'.$upfiles)) {
                    //echo "okk";return;
                    $myfile = Yii::getAlias('@backend').'/web/uploads/files/'  . $upfiles;
                    $file = fopen($myfile, "r");
                    fwrite($file, "\xEF\xBB\xBF");

                    setlocale(LC_ALL, 'th_TH.TIS-620');
                    $i = -1;
                    $res = 0;
                    $data = [];
                    while (($rowData = fgetcsv($file, 10000, ",")) !== FALSE) {
                        $i += 1;
                        if ($rowData[0] == '' || $i == 0) {
                            continue;
                        }
                        $modelprod = \backend\models\Product::find()->where(['product_code' => $rowData[0]])->one();
                        if (count($modelprod) > 0) {
                            // $data_all +=1;
                            // array_push($data_fail,['name'=>$rowData[0][1]]);
                            continue;
                        }
                        $modelx = new \backend\models\Product();
                        $modelx->product_code = $rowData[0];
                        $modelx->barcode = $rowData[0];
                        $modelx->name = $rowData[1];
                        $modelx->description = $rowData[1] ;
                        $modelx->category_id = $this->checkCat($rowData[2]);
                        $modelx->unit_id = $this->checkUnit($rowData[3]);
                        $modelx->price = $rowData[5];
                        $modelx->cost = $rowData[6];
                        $modelx->all_qty = str_replace(',','', $rowData[4]);;
                        $modelx->available_qty = str_replace(',','', $rowData[4]);;
                        $modelx->status = 1;

                        if ($modelx->save(false)) {
                            $res += 1;
                            // $data_all +=1;

                             array_push($data,['product_id'=>$modelx->id,'qty'=>$modelx->all_qty,'warehouse_id'=>1,'line_price'=>0]);
                        }
                    }
                     $res = \backend\models\Journal::createTrans(\backend\helpers\StockType::TYPE_IN,$data,"",\backend\helpers\JournalType::TYPE_IMPORT);
                    if($res > 0 ){
                        $session = Yii::$app->session;
                        $session->setFlash('msg','นำเข้าข้อมูลสินค้าเรียบร้อย');
                        return $this->redirect(['index']);
                    }else{
                        $session = Yii::$app->session;
                        $session->setFlash('msg-error','พบข้อมผิดพลาด');
                        return $this->redirect(['index']);
                    }
                    unlink(chmod(Yii::getAlias('@backend') .'/web/uploads/files/'.$upfiles,777));
                }
                fclose($file);
            }else{

            }
        }
    }
    public function actionImportupdate(){
        $model = new \backend\models\Uploadfile();
        if(Yii::$app->request->post()){
            $uploaded = UploadedFile::getInstance($model, 'file');
            if(!empty($uploaded)) {
                $upfiles = time() . "." . $uploaded->getExtension();
                if($uploaded->saveAs('../web/uploads/files/'.$upfiles)) {
                    //echo "okk";return;
                    $myfile = '../web/uploads/files/' . $upfiles;
                    $file = fopen($myfile, "r");
                    fwrite($file, "\xEF\xBB\xBF");

                    setlocale(LC_ALL, 'th_TH.TIS-620');
                    $i = -1;
                    $res = 0;
                    $data = [];
                    $update_stock = false;
                    while (($rowData = fgetcsv($file, 10000, ",")) !== FALSE) {
                        $i += 1;
                        if ($rowData[0] == '' || $i == 0) {
                            continue;
                        }
                        $modelprod = \backend\models\Product::find()->where(['product_code' => $rowData[0]])->one();
                        if (count($modelprod) > 0) {
                            $modelprod->price = $rowData[5];
                            $modelprod->cost = $rowData[6];
                            $modelprod->category_id = $this->checkCat($rowData[2]);
                            $modelprod->unit_id = $this->checkUnit($rowData[3]);
                            $modelprod->all_qty = str_replace(',','', $rowData[4]);
                            if($modelprod->save(false)){
                                $res += 1;
                                array_push($data,['prod_id'=>$modelprod->id,'qty'=>$modelprod->all_qty,'warehouse_id'=>1,'trans_type'=>TransType::TRANS_ADJUST]);
                            }
                        }else{
                            $modelx = new \backend\models\Product();
                            $modelx->product_code = $rowData[0];
                            $modelx->barcode = $rowData[0];
                            $modelx->name = $rowData[1];
                            $modelx->description = $rowData[1] ;
                            $modelx->category_id = $this->checkCat($rowData[2]);
                            $modelx->unit_id = $this->checkUnit($rowData[3]);
                            $modelx->price = $rowData[5];
                            $modelx->cost = str_replace(',','', $rowData[6]);
                            $modelx->all_qty = str_replace(',','', $rowData[4]);
                            $modelx->available_qty = str_replace(',','', $rowData[4]);
                            $modelx->status = 1;
                            if ($modelx->save(false)) {
                                $res += 1;
                                // $data_all +=1;
                                array_push($data,['prod_id'=>$modelx->id,'qty'=>$modelx->all_qty,'warehouse_id'=>1,'trans_type'=>TransType::TRANS_ADJUST]);
                            }
                        }
                        $update_stock = TransCalculate::createJournal($data);
                    }

                    if($res > 0 && $update_stock ){
                        $session = Yii::$app->session;
                        $session->setFlash('msg','นำเข้าข้อมูลสินค้าเรียบร้อย');
                        return $this->redirect(['index']);
                    }else{
                        $session = Yii::$app->session;
                        $session->setFlash('msg-error','พบข้อมผิดพลาด');
                        return $this->redirect(['index']);
                    }
                }
                fclose($file);
            }else{

            }
        }
    }
    public function checkCat($name){
        $model = \backend\models\Productcat::find()->where(['name'=>$name])->one();
        if(count($model)>0){
            return $model->id;
        }else{
            $model_new = new \backend\models\Productcat();
            $model_new->name = $name;
            $model_new->status = 1;
            if($model_new->save(false)){
                return $model_new->id;
            }
        }
    }
    public function checkUnit($name){
        $model = \backend\models\Unit::find()->where(['name'=>$name])->one();
        if(count($model)>0){
            return $model->id;
        }else{
            $model_new = new \backend\models\Unit();
            $model_new->name = $name;
            $model_new->status = 1;
            if($model_new->save(false)){
                return $model_new->id;
            }
        }
    }
    public function actionPrintbarcode(){
        if(Yii::$app->request->post()){
            $prod_id = Yii::$app->request->post('product_listid');
            $paper_type = Yii::$app->request->post('paper_type');
            $paper_format = Yii::$app->request->post('paper_format');
            $qty = Yii::$app->request->post('qty');

            $show_code = Yii::$app->request->post('show_code');
            $show_name = Yii::$app->request->post('show_name');

            $prodid = explode(',',$prod_id);
            $paper_size =  Pdf::FORMAT_LEGAL;
            $orient =  Pdf::ORIENT_PORTRAIT;

            if($paper_format == 1){
                $orient = Pdf::ORIENT_LANDSCAPE;
            }
            if($paper_type == 0){
                $paper_size = [100,50];
            }else if($paper_type == 1){
                $paper_size = Pdf::FORMAT_A4;
            }else if($paper_type == 2){
                $paper_size = Pdf::FORMAT_LETTER;
            }


            $modellist = Product::find()->where(['id'=>$prodid])->all();

            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                'format' => $paper_size,
               // 'format' => [60, 30],//กำหนดขนาด
                'orientation' => $orient,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('_print',[
                    'list'=>$modellist,
                    'barcode_qty' => $qty,
                    'show_code' => $show_code,
                    'show_name' => $show_name,
                    // 'from_date'=> $from_date,
                    // 'to_date' => $to_date,
                ]),
                //'content' => "nira",
                'cssFile' => '@backend/web/css/pdf.css',
               // 'cssFile' => '@frontend/web/css/kv-mpdf-bootstrap.css',
                'options' => [
                    'title' => 'บาร์โต้ดรหัสสินค้า',
                    'subject' => ''
                ],
                'methods' => [
                  //  'SetHeader' => ['บาร์โค้ดรหัสสินค้า||Generated On: ' . date("r")],
                  //  'SetFooter' => ['|Page {PAGENO}|'],
                ]
            ]);
            return $pdf->render();

        }
    }
    public function actionExport($type){
        if($type !=''){

            $contenttype = "";
            $fileName = "";

            if($type == 'xsl'){
                $contenttype = "application/x-msexcel";
                $fileName="export_product.xls";
            }
            if($type == 'csv'){
                $contenttype = "application/csv";
                $fileName="export_product.csv";
            }

            header('Content-Encoding: UTF-8');
            header("Content-Type: ".$contenttype." ; name=\"$fileName\" ;charset=utf-8");
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            header("Content-Transfer-Encoding: binary");
            header("Pragma: no-cache");
            header("Expires: 0");

            print "\xEF\xBB\xBF";

            $model = Product::find()->where(['id'=>1])->all();
            if($model){
                echo "
                       <table border='1'>
                         <tr>
                            <td>Product Code</td>
                            <td>Name</td>
                            <td>Category</td>
                            <td>Unit</td>
                            <td>Qty</td>
                            <td>Price</td>
                            <td>Cost</td>
                        </tr>
                       
                    ";
                foreach($model as $data){
                    $cat = \backend\models\Productcat::findGroupname($data->category_id);
                    $unit = \backend\models\Unit::findUnitname($data->unit_id);
                    echo "
                        <tr>
                            <td>$data->product_code</td>
                            <td>$data->name</td>
                            <td>$cat</td>
                            <td>$unit</td>
                            <td>$data->all_qty</td>
                            <td>$data->price</td>
                            <td>$data->cost</td>
                        </tr>
                    ";
                }
                echo "</table>";
            }
        }
    }
        public function actionUploadphoto(){
            $model = new Uploadfile();
            $prodid = Yii::$app->request->post('product_id');
            $uploaded = UploadedFile::getInstances($model, 'file');
            if(!empty($uploaded)) {
                //print_r($uploaded);return;
                foreach($uploaded as $data){
                    $modelphoto = new \backend\models\Productgallery();
                    $upfiles = time() . "." . $data->getExtension();
                    if($data->saveAs('../web/uploads/gallery/'.$upfiles)) {
                       $modelphoto->product_id = $prodid;
                       $modelphoto->photo = $upfiles;
                    }
                    $modelphoto->save(false);

                }
            }
            return $this->redirect(['view','id'=>$prodid]);
        }
        public function actionDeletephoto($id,$prodid){
            \backend\models\Productgallery::deleteAll(['id'=>$id]);
            return $this->redirect(['view','id'=>$prodid]);
        }
    public function actionPrintstock(){
        if(Yii::$app->request->isPost){
            $prod_id = Yii::$app->request->post('product_stocklist');
            $stock_type = Yii::$app->request->post('stock_type');
            if($prod_id!=''){
                //$model = new \backend\models\Journal();
                if($stock_type ==1){
                    $paper_size =  Pdf::FORMAT_A4;
                    $orient =  Pdf::ORIENT_PORTRAIT;
                    $prodid = explode(',',$prod_id);

                    $modellist = \backend\models\Stockbalance::find()->where(['id'=>$prodid])->all();

                    $pdf = new Pdf([
                        'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                        'format' => $paper_size,
                        // 'format' => [60, 30],//กำหนดขนาด
                        'orientation' => $orient,
                        'destination' => Pdf::DEST_BROWSER,
                        'content' => $this->renderPartial('_printstock',[
                            'list'=>$modellist,
                        ]),
                        //'content' => "nira",
                        'cssFile' => '@backend/web/css/pdf.css',
                        // 'cssFile' => '@frontend/web/css/kv-mpdf-bootstrap.css',
                        'options' => [
                            'title' => 'รายการจำนวนสินค้า',
                            'subject' => ''
                        ],
                        'methods' => [
                              'SetHeader' => ['รายการจำนวนสินค้า||Generated On: ' . date("r")],
                              'SetFooter' => ['|Page {PAGENO}|'],
                        ]
                    ]);
                    return $pdf->render();
                }else{

                }
            }
        }
    }
    public function actionAddvendorline(){
        return $this->renderPartial('_addvendor');
    }
    public function actionFindvendor(){
      // return Json::encode(['AX2012','AX2018']);
        $term = Yii::$app->request->post('query');
        $product = Product::find()->where(['LIKE','product_code',$term])->all();
        $lists = [];
        foreach($product as $country) {
            $lists[] =[
                'id' => $country->id,
                'name' => $country->name,
                'code' => $country->product_code,
            ];
        }
        print_r($product);
       // return Json::encode($lists);
    }
    public function actionDeletepic(){
        //$id = \Yii::$app->request->post("product_id");
        $picid = \Yii::$app->request->post("pic_id");
        if($picid){
            $model = \backend\models\Productpic::find()->where(['id'=>$picid])->one();
            if($model){
                unlink(Yii::getAlias('@backend') .'/web/uploads/'.$model->picture);
                \backend\models\Productpic::deleteAll(['id'=>$picid]);
            }

            return true;
        }
    }
}
