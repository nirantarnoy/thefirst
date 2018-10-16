<?php

namespace backend\controllers;

use Yii;
use backend\models\Authitem;
use backend\models\AuthitemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AuthitemController implements the CRUD actions for Authitem model.
 */
class AuthitemController extends Controller
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
            'access'=>[
                'class'=>AccessControl::className(),
                'rules'=>[
                    [
                        'allow'=>true,
                        'actions'=>['index','create','update','view','resetpassword','managerule'],
                        'roles'=>['@'],
                    ],
                    [
                        'allow'=>true,
                        'actions'=>['delete'],
                        'roles'=>['System Administrator'],
                    ]

                ]
            ]
        ];
    }

    /**
     * Lists all Authitem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new AuthitemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Authitem model.
     * @param string $id
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
     * Creates a new Authitem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Authitem();

        if ($model->load(Yii::$app->request->post())) {
            $auth = Yii::$app->authManager;
            //$auth->removeAll();

            $newrole = $auth->createRole($model->name);
            $newrole->description = $model->description;
            $newrole->type = $model->type;
            $auth->add($newrole);


                $session = Yii::$app->session;
                $session->setFlash('msg','บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Authitem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelchild = \backend\models\Auhtitemchild::find()->where(['parent'=>$model->name])->all();

        if ($model->load(Yii::$app->request->post())) {

            $childlist = $model->child_list;
           // echo $model->name;return;

          //  print_r($childlist);return;

            $auth = Yii::$app->authManager;
            $olditem = $auth->getRole($model->name);
            $olditem->description = $model->description;
            $olditem->type = $model->type;

            $auth->update($model->name,$olditem);

            if(sizeof($childlist)>0){
               for($i=0;$i<=count($childlist)-1;$i++){
                   //echo $childlist[$i];return;
                   $childitem = $auth->getRole($childlist[$i]);
                   $auth->addChild($olditem,$childitem);
               }

            }


            $session = Yii::$app->session;
            $session->setFlash('msg','บันทึกรายการเรียบร้อย');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'modelchild'=> $modelchild,
        ]);
    }

    /**
     * Deletes an existing Authitem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteRecord', ['user_id' => Yii::$app->user->id])) {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }else{

        }

    }

    /**
     * Finds the Authitem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Authitem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Authitem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionManagerule(){

        $auth = Yii::$app->authManager;
        $auth->removeAll();

       // $rule = new \common\rbac\DeleteRecordRule(); // rule ที่สร้างไว้
      //  $auth->add($rule);

        // site module

//        $site_index = $auth->createPermission('site/index');
//        $auth->add($site_index);
//        $site_logout = $auth->createPermission('site/logout');
//        $auth->add($site_logout);
//        $site_login = $auth->createPermission('site/login');
//        $auth->add($site_login);
//
//        $site_permission = $auth->createPermission('sitemodule');
//        $site_permission->description = "หน้าหลัก";
//        $auth->add($site_permission);
//        $auth->addChild($site_permission,$site_index);
//        $auth->addChild($site_permission,$site_logout);

//        $suplier = $auth->createRole('Suplier');
//        $suplier->description = "Suplier";
//        $auth->add($suplier);
//        $auth->addChild($suplier,$site_permission);

        // plan_module
        $plant_index = $auth->createPermission('plant/index');
        $auth->add($plant_index);
        $plant_update = $auth->createPermission('plant/update');
        $auth->add($plant_update);
        $plant_delete = $auth->createPermission('plant/delete');
        $auth->add($plant_delete);
        $plant_view = $auth->createPermission('plant/view');
        $auth->add($plant_view);
        $plant_create = $auth->createPermission('plant/create');
        $auth->add($plant_create);

        $plant_permission = $auth->createPermission('plantmodule');
        $plant_permission->description = "สิทธิ์ใช้งานโมดูล Plant";
        $auth->add($plant_permission);

        $auth->addChild($plant_permission,$plant_index);
        $auth->addChild($plant_permission,$plant_view);
        $auth->addChild($plant_permission,$plant_update);
        $auth->addChild($plant_permission,$plant_delete);
        $auth->addChild($plant_permission,$plant_create);

        $manage_plant = $auth->createRole('Manage Plant');
        $manage_plant->description = "Manage plant";
        $auth->add($manage_plant);
        $auth->addChild($manage_plant,$plant_permission);

        // user_module
        $user_index = $auth->createPermission('user/index');
        $auth->add($user_index);
        $user_update = $auth->createPermission('user/update');
        $auth->add($user_update);
        $user_delete = $auth->createPermission('user/delete');
        $auth->add($user_delete);
        $user_view = $auth->createPermission('user/view');
        $auth->add($user_view);
        $user_create = $auth->createPermission('user/create');
        $auth->add($user_create);

        $user_permission = $auth->createPermission('usermodule');
        $user_permission->description = "สิทธิ์ใช้งานโมดูล user";
        $auth->add($user_permission);

        $auth->addChild($user_permission,$user_index);
        $auth->addChild($user_permission,$user_view);
        $auth->addChild($user_permission,$user_update);
        $auth->addChild($user_permission,$user_delete);
        $auth->addChild($user_permission,$user_create);

        $manage_user = $auth->createRole('Manage user');
        $manage_user->description = "Manage user";
        $auth->add($manage_user);
        $auth->addChild($manage_user,$user_permission);

        // user_group_module
        $usergroup_index = $auth->createPermission('usergroup/index');
        $auth->add($usergroup_index);
        $usergroup_update = $auth->createPermission('usergroup/update');
        $auth->add($usergroup_update);
        $usergroup_delete = $auth->createPermission('usergroup/delete');
        $auth->add($usergroup_delete);
        $usergroup_view = $auth->createPermission('usergroup/view');
        $auth->add($usergroup_view);
        $usergroup_create = $auth->createPermission('usergroup/create');
        $auth->add($usergroup_create);

        $usergroup_permission = $auth->createPermission('usergroupmodule');
        $usergroup_permission->description = "สิทธิ์ใช้งานโมดูล usergroup";
        $auth->add($usergroup_permission);

        $auth->addChild($usergroup_permission,$usergroup_index);
        $auth->addChild($usergroup_permission,$usergroup_view);
        $auth->addChild($usergroup_permission,$usergroup_update);
        $auth->addChild($usergroup_permission,$usergroup_delete);
        $auth->addChild($usergroup_permission,$usergroup_create);

        $manage_usergroup = $auth->createRole('Manage usergroup');
        $manage_usergroup->description = "Manage usergroup";
        $auth->add($manage_usergroup);
        $auth->addChild($manage_usergroup,$usergroup_permission);

        // product module
        $product_index = $auth->createPermission('product/index');
        $auth->add($product_index);
        $product_update = $auth->createPermission('product/update');
        $auth->add($product_update);
        $product_delete = $auth->createPermission('product/delete');
        $auth->add($product_delete);
        $product_view = $auth->createPermission('product/view');
        $auth->add($product_view);
        $product_create = $auth->createPermission('product/create');
        $auth->add($product_create);

        $product_permission = $auth->createPermission('productmodule');
        $product_permission->description = "สิทธิ์ใช้งานโมดูล product";
        $auth->add($product_permission);

        $auth->addChild($product_permission,$product_index);
        $auth->addChild($product_permission,$product_view);
        $auth->addChild($product_permission,$product_update);
        $auth->addChild($product_permission,$product_delete);
        $auth->addChild($product_permission,$product_create);

        $manage_product = $auth->createRole('Manage product');
        $manage_product->description = "Manage Product";
        $auth->add($manage_product);
        $auth->addChild($manage_product,$product_permission);



        // purchase module
        $purch_index = $auth->createPermission('purch/index');
        $auth->add($purch_index);
        $purch_update = $auth->createPermission('purch/update');
        $auth->add($purch_update);
        $purch_delete = $auth->createPermission('purch/delete');
        $auth->add($purch_delete);
        $purch_view = $auth->createPermission('purch/view');
        $auth->add($purch_view);
        $purch_bill = $auth->createPermission('purch/bill');
        $auth->add($purch_bill);
        $purch_create = $auth->createPermission('purch/create');
        $auth->add($purch_create);
        $purch_cancelqc = $auth->createPermission('purch/cancelqc');
        $auth->add($purch_cancelqc);
        $purch_createinv = $auth->createPermission('purch/createinv');
        $auth->add($purch_createinv);
        $purch_finditem = $auth->createPermission('purch/finditem');
        $auth->add($purch_finditem);

        $purch_permission = $auth->createPermission('purchmodule');
        $purch_permission->description = "สิทธิ์ใช้งานโมดูล purch";
        $auth->add($purch_permission);

        $auth->addChild($purch_permission,$purch_index);
        $auth->addChild($purch_permission,$purch_view);
        $auth->addChild($purch_permission,$purch_update);
        $auth->addChild($purch_permission,$purch_delete);
        $auth->addChild($purch_permission,$purch_bill);
        $auth->addChild($purch_permission,$purch_create);
        $auth->addChild($purch_permission,$purch_cancelqc);
        $auth->addChild($purch_permission,$purch_createinv);
        $auth->addChild($purch_permission,$purch_finditem);

        $manage_purch = $auth->createRole('Manage purch');
        $manage_purch->description = "Manage product received";
        $auth->add($manage_purch);
        $auth->addChild($manage_purch,$purch_permission);



        //prodissue module
        $sale_index = $auth->createPermission('sale/index');
        $auth->add($sale_index);
        $sale_update = $auth->createPermission('sale/update');
        $auth->add($sale_update);
        $sale_delete = $auth->createPermission('sale/delete');
        $auth->add($sale_delete);
        $sale_view = $auth->createPermission('sale/view');
        $auth->add($sale_view);
        $sale_create = $auth->createPermission('sale/create');
        $auth->add($sale_create);
        $sale_showemp = $auth->createPermission('sale/showemp');
        $auth->add($sale_showemp);
        $sale_getzoneinfo = $auth->createPermission('sale/getzoneinfo');
        $auth->add($sale_getzoneinfo);
        $sale_cancel = $auth->createPermission('sale/cancel');
        $auth->add($sale_cancel);
        $sale_confirm = $auth->createPermission('sale/confirmsale');
        $auth->add($sale_confirm);
        $sale_finditem = $auth->createPermission('sale/finditem');
        $auth->add($sale_finditem);

        $sale_permission = $auth->createPermission('salemodule');
        $sale_permission->description = "สิทธิ์ใช้งานโมดูล sale";
        $auth->add($sale_permission);

        $auth->addChild($sale_permission,$sale_index);
        $auth->addChild($sale_permission,$sale_view);
        $auth->addChild($sale_permission,$sale_update);
        $auth->addChild($sale_permission,$sale_delete);
        $auth->addChild($sale_permission,$sale_create);
        $auth->addChild($sale_permission,$sale_showemp);
        $auth->addChild($sale_permission,$sale_getzoneinfo);
        $auth->addChild($sale_permission,$sale_cancel);
        $auth->addChild($sale_permission,$sale_confirm);
        $auth->addChild($sale_permission,$sale_finditem);

        $manage_sale = $auth->createRole('Manage sale');
        $manage_sale->description = "Manage product issue";
        $auth->add($manage_sale);
        $auth->addChild($manage_sale,$sale_permission);


        //employee module
        $employee_index = $auth->createPermission('employee/index');
        $auth->add($employee_index);
        $employee_update = $auth->createPermission('employee/update');
        $auth->add($employee_update);
        $employee_delete = $auth->createPermission('employee/delete');
        $auth->add($employee_delete);
        $employee_view = $auth->createPermission('employee/view');
        $auth->add($employee_view);
        $employee_create = $auth->createPermission('employee/create');
        $auth->add($employee_create);

        $employee_permission = $auth->createPermission('employeemodule');
        $employee_permission->description = "สิทธิ์ใช้งานโมดูล employee";
        $auth->add($employee_permission);

        $auth->addChild($employee_permission,$employee_index);
        $auth->addChild($employee_permission,$employee_view);
        $auth->addChild($employee_permission,$employee_update);
        $auth->addChild($employee_permission,$employee_delete);
        $auth->addChild($employee_permission,$employee_create);

        $manage_employee = $auth->createRole('Manage employee');
        $manage_employee->description = "Manage invoice";
        $auth->add($manage_employee);
        $auth->addChild($manage_employee,$employee_permission);

        //claim module
        $claim_index = $auth->createPermission('claim/index');
        $auth->add($claim_index);
        $claim_update = $auth->createPermission('claim/update');
        $auth->add($claim_update);
        $claim_delete = $auth->createPermission('claim/delete');
        $auth->add($claim_delete);
        $claim_view = $auth->createPermission('claim/view');
        $auth->add($claim_view);
        $claim_create = $auth->createPermission('claim/create');
        $auth->add($claim_create);
        $claim_findso = $auth->createPermission('claim/findso');
        $auth->add($claim_findso);

        $claim_permission = $auth->createPermission('claimmodule');
        $claim_permission->description = "สิทธิ์ใช้งานโมดูล claim";
        $auth->add($claim_permission);

        $auth->addChild($claim_permission,$claim_index);
        $auth->addChild($claim_permission,$claim_view);
        $auth->addChild($claim_permission,$claim_update);
        $auth->addChild($claim_permission,$claim_delete);
        $auth->addChild($claim_permission,$claim_create);
        $auth->addChild($claim_permission,$claim_findso);

        $manage_claim = $auth->createRole('Manage claim');
        $manage_claim->description = "Manage claim";
        $auth->add($manage_claim);
        $auth->addChild($manage_claim,$claim_permission);


        //message module
        $message_index = $auth->createPermission('message/index');
        $auth->add($message_index);
        $message_update = $auth->createPermission('message/update');
        $auth->add($message_update);
        $message_delete = $auth->createPermission('message/delete');
        $auth->add($message_delete);
        $message_view = $auth->createPermission('message/view');
        $auth->add($message_view);
        $message_create = $auth->createPermission('message/create');
        $auth->add($message_create);

        $message_permission = $auth->createPermission('messagemodule');
        $message_permission->description = "สิทธิ์ใช้งานโมดูล message";
        $auth->add($message_permission);

        $auth->addChild($message_permission,$message_index);
        $auth->addChild($message_permission,$message_view);
        $auth->addChild($message_permission,$message_update);
        $auth->addChild($message_permission,$message_delete);
        $auth->addChild($message_permission,$message_create);

        $manage_message = $auth->createRole('Manage message');
        $manage_message->description = "Manage message";
        $auth->add($manage_message);
        $auth->addChild($manage_message,$message_permission);

        //warehouse module
        $warehouse_index = $auth->createPermission('warehouse/index');
        $auth->add($warehouse_index);
        $warehouse_update = $auth->createPermission('warehouse/update');
        $auth->add($warehouse_update);
        $warehouse_delete = $auth->createPermission('warehouse/delete');
        $auth->add($warehouse_delete);
        $warehouse_view = $auth->createPermission('warehouse/view');
        $auth->add($warehouse_view);
         $warehouse_create = $auth->createPermission('warehouse/create');
        $auth->add($warehouse_create);

        $warehouse_permission = $auth->createPermission('warehousemodule');
        $warehouse_permission->description = "สิทธิ์ใช้งานโมดูล warehouse";
        $auth->add($warehouse_permission);

        $auth->addChild($warehouse_permission,$warehouse_index);
        $auth->addChild($warehouse_permission,$warehouse_view);
        $auth->addChild($warehouse_permission,$warehouse_update);
        $auth->addChild($warehouse_permission,$warehouse_delete);
        $auth->addChild($warehouse_permission,$warehouse_create);

        $manage_warehouse = $auth->createRole('Manage warehouse');
        $manage_warehouse->description = "Manage message";
        $auth->add($manage_warehouse);
        $auth->addChild($manage_warehouse,$warehouse_permission);





        $admin_role = $auth->createRole('System Administrator');
        $admin_role->description = "ผู้ดูแลระบบ";
        $auth->add($admin_role);

        $auth->addChild($admin_role,$manage_plant);
        $auth->addChild($admin_role,$manage_user);
        $auth->addChild($admin_role,$manage_usergroup);
        $auth->addChild($admin_role,$manage_product);
        $auth->addChild($admin_role,$manage_purch);
        $auth->addChild($admin_role,$manage_sale);
        $auth->addChild($admin_role,$manage_employee);
        $auth->addChild($admin_role,$manage_message);
        $auth->addChild($admin_role,$manage_warehouse);

        $user_role = $auth->createRole('System User');
        $user_role->description = "ผู้ใช้งานทั่วไป";
        $auth->add($user_role);


        $auth->addChild($user_role,$manage_product);
        $auth->addChild($user_role,$manage_purch);



//        $auth->assign($admin_role,17);
//        $auth->assign($user_role,19);






    }
}
/*
 *
 public function init()
    {
      $auth = Yii::$app->authManager;
      $auth->removeAll();
      Console::output('Removing All! RBAC.....');

      $createPost = $auth->createPermission('createBlog');
      $createPost->description = 'สร้าง blog';
      $auth->add($createPost);

      $updatePost = $auth->createPermission('updateBlog');
      $updatePost->description = 'แก้ไข blog';
      $auth->add($updatePost);

      // เพิ่ม permission loginToBackend <<<------------------------
      $loginToBackend = $auth->createPermission('loginToBackend');
      $loginToBackend->description = 'ล็อกอินเข้าใช้งานส่วน backend';
      $auth->add($loginToBackend);

      $manageUser = $auth->createRole('ManageUser');
      $manageUser->description = 'จัดการข้อมูลผู้ใช้งาน';
      $auth->add($manageUser);

      $author = $auth->createRole('Author');
      $author->description = 'การเขียนบทความ';
      $auth->add($author);

      $management = $auth->createRole('Management');
      $management->description = 'จัดการข้อมูลผู้ใช้งานและบทความ';
      $auth->add($management);

      $admin = $auth->createRole('Admin');
      $admin->description = 'สำหรับการดูแลระบบ';
      $auth->add($admin);

      $rule = new \common\rbac\AuthorRule;
      $auth->add($rule);

      $updateOwnPost = $auth->createPermission('updateOwnPost');
      $updateOwnPost->description = 'แก้ไขบทความตัวเอง';
      $updateOwnPost->ruleName = $rule->name;
      $auth->add($updateOwnPost);

      $auth->addChild($author,$createPost);
      $auth->addChild($updateOwnPost, $updatePost);
      $auth->addChild($author, $updateOwnPost);

      // addChild role ManageUser <<<------------------------
      $auth->addChild($manageUser, $loginToBackend);

      $auth->addChild($management, $manageUser);
      $auth->addChild($management, $author);

      $auth->addChild($admin, $management);

      $auth->assign($admin, 1);
      $auth->assign($management, 2);
      $auth->assign($author, 3);
      $auth->assign($author, 4);

      Console::output('Success! RBAC roles has been added.');
    } */