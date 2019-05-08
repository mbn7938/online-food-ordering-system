<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MenuFoodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu Foods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-food-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'menu_id',
                'filter' => ArrayHelper::map(\app\models\Menu::find()->asArray()->all(), 'id', 'name'),
                'value' => function ($model) {
                    return $model->menu->name;
                }
            ],
            [
                'attribute' => 'food_id',
                'filter' => ArrayHelper::map(\app\models\Food::find()->asArray()->all(), 'id', 'name'),
                'value' => function ($model) {
                    return $model->food->name;
                }
            ],
            [
                'attribute' => 'price',
                'label' => 'Price',
                'value' => function ($model) {
                    return 'MYR ' . $model->food->price;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
