<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MenuFood */

$this->title = 'Create Menu Food';
$this->params['breadcrumbs'][] = ['label' => 'Menu Foods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-food-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
