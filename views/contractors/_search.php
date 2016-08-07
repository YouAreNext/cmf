<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContractorsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contractors-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'author') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'client') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'mail') ?>

    <?php // echo $form->field($model, 'now_date') ?>

    <?php // echo $form->field($model, 'next_date') ?>

    <?php // echo $form->field($model, 'now_result') ?>

    <?php // echo $form->field($model, 'next_event') ?>

    <?php // echo $form->field($model, 'project_type') ?>

    <?php // echo $form->field($model, 'meet') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
