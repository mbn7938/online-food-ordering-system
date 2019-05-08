<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($guest, 'name')->textInput() ?>


    <?=
    $form->field($model, 'type')
        ->dropDownList(
           ['','take away','eat here']
        )
    ?>

    <?=
    $form->field($model, 'table_no')->dropDownList(
            [1,2,3,4,5,6,7,8,9,10]
        )
    ?>


    <?php ActiveForm::end(); ?>

    <?php Pjax::begin(); ?>
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

            [

                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->id];
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

    <div class="form-group">
        <button id="order" class="btn btn-success">Order Now</button>
    </div>

</div>
