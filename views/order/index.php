<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'guest_id',
                'label' => 'Guest Name',
                'value' => function ($model) {
                    return (isset($model->guest->name) ? $model->guest->name : '');
                }
            ],
            [
                'attribute' => 'type',
                'label' => 'Order Type',
                'value' => function ($model) {
                    return ($model->type == 1 ? 'TAKE AWAY' : 'EAT HERE');
                }
            ],
            [
                'attribute' => 'status',
                'label' => 'Order Status',
                'format' => 'raw',
                'value' => function ($model) {

                    if ($model->status == 1) {
                        return '<span class="badge badge-info">PENDING</span>';
                    } elseif ($model->status == 2) {
                        return '<span class="badge badge-primary">COOKING</span>';
                    }
                    elseif ($model->status == 4) {
                        return '<span class="badge badge-primary">DONE</span>';
                    }
                    elseif ($model->status == 3) {
                        return '<span class="badge badge-primary">REJECTED</span>';
                    }
                    else {
                        return '<span class="badge badge-primary">PLEASE CALL WAITER</span>';
                    }

                }
            ],
            [
                'attribute' => 'table_no',
                'label' => 'Order Table No.',
                'format' => 'raw',
                'value' => function ($model) {

                    if ($model->type == 2) {
                        return '<span class="badge badge-info">'.$model->table_no.'</span>';
                    }
                    else
                    {
                        return '<span class="badge badge-info">TAKE AWAY</span>';
                    }

                }
            ],
            [
                'attribute' => 'order_at',
                'label' => 'Ordered Time Count',
                'format' => 'raw',
                'value' => function ($model) {

                    $date1=date_create($model->order_at);
                    $date2=date_create(date('Y-m-d H:i:s'));


                    $dteDiff  = $date1->diff($date2);

                    return $dteDiff->format("%H:%I:%S");

                }
            ],

            //'status',

            ['class' => 'yii\grid\ActionColumn',

                'template' => '{accept} {done} {reject}',

                'buttons' => [

                    'accept' => function ($url, $model) {

                        if (Yii::$app->user->can('admin')) {
                            if ($model->status == 1) {
                                return '<a class="btn btn-success btn-sm" href="' . \yii\helpers\Url::to(['order/update-status/', 'id' => $model->id, 'status' => \app\models\Order::ACCEPTED]) . '">Accept</button>';

                            }

                        }


                    },
                    'reject' => function ($url, $model) {

                        if (Yii::$app->user->can('admin')) {
                            if ($model->status == 1) {
                                return '<a class="btn btn-warning btn-sm" href="' . \yii\helpers\Url::to(['order/update-status/', 'id' => $model->id, 'status' => \app\models\Order::REJECTED]) . '">Reject</button>';

                            }
                        }

                        if ($model->status == 3) {
                            return '<a class="btn btn-danger btn-sm" href="">REJECTED</button>';

                        }


                    },
                    'done' => function ($url, $model) {

                        if (Yii::$app->user->can('admin')) {
                            if ($model->status == 2) {
                                return '<a class="btn btn-primary btn-sm" href="' . \yii\helpers\Url::to(['order/update-status/', 'id' => $model->id, 'status' => \app\models\Order::DONE]) . '">Done</button>';

                            }
                        }

                        if ($model->status == 4) {
                            return '<a class="btn btn-primary btn-sm" href="">FOOD READY</button>';

                        }


                    },


                ]

            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
