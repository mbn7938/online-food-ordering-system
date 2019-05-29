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

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <?= Yii::$app->session->getFlash('success') ?>

    <?php endif; ?>

    <?php $form = ActiveForm::begin(['id' => 'order-form']); ?>

    <?= $form->field($guest, 'name')->textInput() ?>

    <?= $form->field($guest, 'email')->textInput() ?>

    <?= $form->field($guest, 'tel_no')->textInput() ?>


    <?=
    $form->field($model, 'type')
        ->dropDownList(
            ['', 'take away', 'eat here']
        )
    ?>

    <?php

    $getAvailableTable = \app\models\Order::find()
        //->select('group_concat(table_no,char(8)) as table_no')
        ->where(['type' => 2])->asArray()
        ->andWhere(['in', 'status', [1, 2]])
        ->asArray()->all();

    //$int = (int)$getAvailableTable['table_no'];


    $array = [];
    foreach ($getAvailableTable as $key => $val) {
        $array[$key] = $val['table_no'];
    }

//    echo '<pre>';
//    var_dump($array);
//    echo '<pre>';
//    die();

    $arrayMap = \app\models\TableNo::find()
        ->where(['not in', 'table_no', $array])
        ->all();


    ?>

    <?=
    $form->field($model, 'table_no')->dropDownList(
        ArrayHelper::map($arrayMap, 'id', 'table_no')
    )
    ?>


    <?php ActiveForm::end(); ?>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'id' => 'order-menu-gridview',
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
