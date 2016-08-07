<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveField;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Contractors */
/* @var $form yii\widgets\ActiveForm */
?>

<ul class="nav nav-tabs nav-justified">
    <li class="active"><a data-toggle="tab" href="#home">Проект</a></li>

    <li><a data-toggle="tab" href="#menu2">Файлы</a></li>
</ul>

<div class="tab-content">

    <div class="contractors-form tab-pane fade in active" id="home">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-4">
                <?php
                    $workers = User::find()->all();
                    $items = ArrayHelper::map($workers,'id','username');
                    $params = [
                        'prompt' => 'Ответственный за проект'
                    ];
                    echo $form->field($model, 'author')->dropDownList($items,$params);
                ?>
                <?= $form->field($model, 'created_at')->textInput(['readonly' => true]) ?>
            </div>
            <div class="col-md-8">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'client')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'mail')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">

                <?= $form->field($model, 'now_date')->widget(
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
            <div class="col-md-4">
                <?= $form->field($model, 'now_result')->dropDownList([
                    '1'=>'Отказ',
                    '2'=>'Отправка КП',
                    '3'=>'Слабый интерес',
                    '4'=>'Сильный интерес',
                    '5'=>'Встреча',
                    '6'=>'Не дозвонился',
                    '7'=>'Перенос',
                    '8'=>'Запрос КП',
                    '9'=>'Другое',
                    '10'=>'Повторный звонок'
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">

                <?= $form->field($model, 'next_date')->widget(
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
            <div class="col-md-4">
                <?= $form->field($model, 'next_event')->dropDownList([
                    '1'=>'Звонок',
                    '2'=>'Встреча',
                    '3'=>'Повторный звонок',
                    '4'=>'Запрос на продвижение',
                    '5'=>'Отправка КП',
                    '6'=>'Ожидание информации от клиента',
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'project_type')->dropDownList([
                        '1'=>'Разработка сайта',
                        '2'=>'Продвижение',
                        '3'=>'Другое'
                    ])
                ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'meet')->textInput(['maxlength' => true]) ?>
            </div>
        </div>




















        <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <div id="menu2" class="tab-pane fade">
        <h3>Menu 2</h3>
        <p>Some content in menu 2.</p>
    </div>
</div>