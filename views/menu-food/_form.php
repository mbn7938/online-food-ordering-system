<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MenuFood */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-food-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
    $form->field($model, 'menu_id')
        ->dropDownList(
            ArrayHelper::map(\app\models\Menu::find()->asArray()->all(), 'id', 'name')
        )
    ?>

    <?=
    $form->field($model, 'food_id')
        ->dropDownList(
            ArrayHelper::map(\app\models\Food::find()->asArray()->all(), 'id', 'name')
        )
    ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
