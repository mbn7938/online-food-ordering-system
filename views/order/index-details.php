<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'menu_food_id',
                'label' => 'Menu',
                'value' => function ($model) {
                    return $model->menuFood->food->name;
                }
            ],
            [
                'attribute' => 'menu_food_id',
                'label' => 'Price',
                'value' => function ($model) {
                    return 'MYR '. $model->menuFood->food->price;
                }
            ],


        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
