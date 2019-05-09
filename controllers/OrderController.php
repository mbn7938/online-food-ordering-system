<?php

namespace app\controllers;

use app\models\Guest;
use app\models\MenuFoodSearch;
use app\models\OrderDetails;
use app\models\Payment;
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
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $orderDetails = OrderDetails::find()->where(['order_id'=>$id])->one();

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


        if (Yii::$app->request->isAjax) {

            $post = Yii::$app->request->post();


            if (isset($post['email'])) {
                $guest = new Guest();
                $guest->email = $post['email'];
                $guest->tel_no = $post['tel_no'];
                if(!$guest->save())
                {
                    $guest->getErrors();
                }

            }
            $order = new Order();

            $order->guest_id = $guest->id;
            $order->type = $post['type'];
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
            }
            $ref = \yii\helpers\Url::to((['/order/pay', 'order_id' => $order->id]));
            return $ref;
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

        $orderFood = OrderDetails::find()->where(['order_id'=>$order_id])->all();

        return $this->render('pay', [
            'orderFood' => $orderFood,
            'order'=> $order
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

        if ($post)
        {

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

        return $this->redirect(['pay','order_id'=>$order_id]);
    }
}
