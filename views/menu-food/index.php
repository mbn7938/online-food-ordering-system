<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
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
            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 8.7%'],
                'visible'=> Yii::$app->user->can('admin') ? true : false,
                'buttons'=>[
                    'view'=>function ($url, $model) {

                        return '<a href='.Url::to(["menu-food/view","id"=> $model->id]).'><span class="glyphicon glyphicon-eye-open"></span></a>';
                    },
                    'update'=>function ($url, $model) {

                        return '<a href='.Url::to(["menu-food/update","id"=> $model->id]).'><span class="glyphicon glyphicon-pencil"></span></a>';
                    },
                ],
            ],


        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
