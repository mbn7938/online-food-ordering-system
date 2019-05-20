<?php

namespace app\controllers;

use app\models\Guest;
use app\models\MenuFoodSearch;
use app\models\OrderDetails;
use app\models\Payment;
use app\modules\user\models\User;
use Yii;
use app\models\Order;
use app\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {


        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionMyOrder()
    {
        $user = Yii::$app->user->identity;

        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->searchOwn(Yii::$app->request->queryParams, $user);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $orderDetails = OrderDetails::find()->where(['order_id' => $id])->one();

        return $this->render('view', [
            'orderDetails' => $orderDetails,
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        $guest = new Guest();


        if (!Yii::$app->user->isGuest) {

            $user = Yii::$app->user->identity;

            $guest = Guest::find()->where(['email' => $user->email])->one();

            if(!$guest)
            {
                $guest = new Guest();
            }
        }


        if (Yii::$app->request->isAjax) {

            $post = Yii::$app->request->post();

            if (isset($post['email'])) {

                if (!Yii::$app->user->isGuest) {

                    $guest = Guest::find()->where(['email' => $user->email])->one();

                    if(!$guest)
                    {
                        $newGuest = new Guest();
                        $newGuest->email = $post['email'];
                        $newGuest->tel_no = $post['tel_no'];

                        $newGuest->save();
                    }

                }
                else
                {
                    $newGuest = new Guest();
                    $newGuest->email = $post['email'];
                    $newGuest->tel_no = $post['tel_no'];

                    $newGuest->save();
                    $user = User::find()->where(['email' => $post['email']])->one();

                    if (!$user) {

                        $password = 'neo';

                        $newUser = new User();
                        $newUser->role_id = 2;
                        $newUser->email = $post['email'];
                        //$newUser->username = $post['email'];
                        $newUser->status = 1;
                        $newUser->password = $password;

                        if (!$newUser->save()) {
                            var_dump($newUser->getErrors());
                        }
                    }
                }




            }

            $order = new Order();

            $order->guest_id = (isset($newGuest)?$newGuest->id:$guest->id);
            $order->type = $post['type'];
            $order->status = Order::ORDERED;
            $order->table_no = (isset($post['tableno']) ? $post['tableno'] : null);
            $order->order_at = date('Y-m-d H:i:s');

            if ($order->save()) {

                foreach ($post['checkedRowId'] as $orderMenu) {
                    $orderDetails = new OrderDetails();

                    $orderDetails->order_id = $order->id;
                    $orderDetails->menu_food_id = $orderMenu;
                    $orderDetails->status = 1;
                    $orderDetails->save();
                }

                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


                $ref = \yii\helpers\Url::to((['/order/pay', 'order_id' => $order->id]));
                return $ref;
            }
            else
            {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


                $ref = \yii\helpers\Url::to((['/order/create']));
                return $ref;
            }

        }


        $searchModel = new MenuFoodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'guest' => $guest
        ]);
    }

    /**
     * Updates an existing Order model.
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
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateStatus($id,$status = null)
    {
        $model = $this->findModel($id);

        $model->status = $status;

        $model->save();

        return $this->redirect(['index']);
    }


    /**
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPay($order_id)
    {
        $order = Order::findOne($order_id);

        $orderFood = OrderDetails::find()->where(['order_id' => $order_id])->all();

        return $this->render('pay', [
            'orderFood' => $orderFood,
            'order' => $order
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPayment()
    {
        $post = Yii::$app->request->post();

        $order_id = $post['order_id'];

        if ($post) {

            $total_amount = $post['total_amount'];

            $model = new Payment();

            $model->total_amount = $total_amount;
            $model->paid_amount = $total_amount;
            $model->paid_at = date('Y-m-d H:i:s');
            $model->order_id = $order_id;
            $model->total_amount = $total_amount;

            $model->save();

            Yii::$app->session->setFlash('success', "Your Order Payment Succesfull.");

            return $this->redirect(['create']);

        }

        return $this->redirect(['pay', 'order_id' => $order_id]);
    }
}
