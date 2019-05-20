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
                'format' => 'html',
                'value' => function ($model) {

                    if ($model->status == 1) {
                        return '<span class="badge badge-primary">PENDING</span>';
                    }
                    elseif($model->status == 2)
                    {
                        return '<span class="badge badge-primary">COOKING</span>';
                    }
                    else
                    {
                        return '<span class="badge badge-primary">REJECTED</span>';
                    }

                }
            ],
            'table_no',
            //'status',

            ['class' => 'yii\grid\ActionColumn',

                'template' => '{accept} {reject}',

                'buttons' => [

                    'accept' => function ($url, $model) {

                        if ($model->status != 2) {
                            return '<a class="btn btn-success btn-sm" href="' . \yii\helpers\Url::to(['order/update-status/', 'id' => $model->id, 'status' => \app\models\Order::ACCEPTED]) . '">Accept</button>';

                        }


                    },
                    'reject' => function ($url, $model) {

                        if ($model->status != 3) {
                            return '<a class="btn btn-warning btn-sm" href="' . \yii\helpers\Url::to(['order/update-status/', 'id' => $model->id, 'status' => \app\models\Order::REJECTED]) . '">Reject</button>';

                        }


                    },


                ]

            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
