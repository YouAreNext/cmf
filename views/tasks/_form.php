<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use yii\helpers\ArrayHelper;
use app\models\Projects;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Tasks */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="tasks-form">

    <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?php
                    $workers = User::find()->all();
                    $items = ArrayHelper::map($workers,'id','username');
                    $params = [
                      'prompt' => 'Укажите исполнителя'
                    ];
                    echo $form->field($model, 'worker')->dropDownList($items,$params);
                ?>
                <?php
                    echo $form->field($model, 'Status')->dropDownList([
                        '1' => 'Активная задача',
                        '2' => 'Завершено'
                    ]);
                ?>

                <?= $form->field($model, 'project_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Projects::find()->all(),'id','Title'),
                    'options' => ['placeholder' => 'Привязать к проекту...'],
                ]); ?>
            </div>
            <div class="col-md-8">
                <?= $form->field($model, 'description')->textarea() ?>

                <div class="col-md-6 wpad wpad-first">
                    <?= $form->field($model, 'created_at')->textInput(['readonly' => true]) ?>
                </div>
                <div class="col-md-6 wpad">
                    <?= $form->field($model, 'finish_date')->widget(
                        DatePicker::className(), [
                        // inline too, not bad
                        'inline' => false,
                        'language' =>'ru',
                        // modify template for custom rendering
                        //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                        'clientOptions' => [
                            'autoclose' => true,

                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);?>
                </div>

            </div>

        </div>
<!--        <?//= $form->field($model, 'id')->textInput() ?>-->
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'worker_comment')->textarea(['rows' => 10]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
<!--
                <?= $form->field($model, 'task_complete')->widget(
                    DatePicker::className(), [
                    // inline too, not bad
                    'inline' => false,
                    'language' =>'ru',
                    // modify template for custom rendering
                    //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                    'clientOptions' => [
                        'autoclose' => true,

                        'format' => 'yyyy-mm-dd'
                    ]
                ]);?>
-->

            </div>
        </div>












    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
