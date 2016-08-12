<?php

use app\models\Tasks;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
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

<ul class="nav nav-tabs nav-justified">
    <li class="active"><a data-toggle="tab" href="#page1">Задача</a></li>
    <li><a data-toggle="tab" href="#page2">Подзадачи</a></li>
    <li><a data-toggle="tab" href="#page3">Файлы</a></li>
</ul>
<div class="tab-content tab-content-projects clearfix">
<div class="tasks-form tab-pane fade in active" id="page1">

    <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?php
                    $workers = User::find()->all();
                    $workers = \app\models\Profile::find()->all();
                    $items = ArrayHelper::map($workers,'user_id','first_name');

                    $params = [
                      'prompt' => 'Укажите исполнителя'
                    ];
                    echo $form->field($model, 'worker')->dropDownList($items,$params);
                ?>
                <?php


                if(isset($model->task_creator)){
                    if($model->Status == 1){
                        echo $form->field($model, 'Status')->dropDownList([
                            '1' => 'Активная задача',
                            '3' => 'Отправить на проверку',
                        ]);
                    } else if(($model->Status == 3)&& $userId == $model->task_creator){
                        echo $form->field($model, 'Status')->dropDownList([
                            '1' => 'Вернуть на доработку',
                            '3' => 'Отправить на проверку',
                            '2' => 'Завершено',
                        ]);
                    } else if($model->Status == 3){
                        echo '<div class="task-checking">Задача находится на проверке!</div>';
                    }else if(($model->Status == 2)&& $userId == $model->task_creator){
                        echo $form->field($model, 'Status')->dropDownList([
                            '1' => 'Вернуть на доработку',
                            '2' => 'Завершено',
                        ]);
                    }


                } else{
                    echo $form->field($model, 'Status')->dropDownList([
                        '1' => 'Активная задача',
                        '2' => 'Завершить задачу',
                    ]);
                }

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
                            // modify template for custom rendering
                            'language'=>'ru',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'todayBtn' => true,
                                'todayHighlight' => true,
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
-->

            </div>
        </div>












    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
    <div class="tasks-form tab-pane fade in" id="page2">

        <div class="row">
            <?php
            if ($model->isNewRecord){

            }else{

                $dataPeriodQuery = Tasks::find()->andFilterWhere([
                    'prev_task' => $model->id,
                ]);
                $dataPeriod = new ActiveDataProvider([
                    'query' => $dataPeriodQuery,
                    'sort' => [
                        'defaultOrder' =>['finish_date'=>SORT_ASC]
                    ],

                ]);



                echo ListView::widget([
                    'dataProvider' => $dataPeriod,
                    'itemView' => function($dataPeriod){
                        return '
                    <a href="/tasks/update?id='.$dataPeriod->id.'" class="period-task-item col-md-6">
                        '.$dataPeriod->title.'
                        <span class="sub-status sub-status'.$dataPeriod->Status.'"></span>
                    </a>
                    <div class="col-md-3 period-worker">'.

                        \app\models\Profile::find()->where(['user_id'=>$dataPeriod->worker])->one()->first_name
                        .'</div>
                    <div class="period-task-date col-md-3 "><span class="glyphicon glyphicon-calendar"></span>'.$dataPeriod->finish_date.' </div>

                    ';
                    },
                    'options' => [
                        'tag' => 'div',
                        'class' => 'period-tasker',
                    ],
                    'itemOptions' => [
                        'tag' => 'div',
                        'class' => 'period-task col-md-12',
                    ],
                    'emptyText' => '<p>Нет подзадач</p>',
                    'emptyTextOptions' => [
                        'tag' => 'p'
                    ],
                    'summary' => '<p class="total-task">Всего подзадач: <span class="bold-span">{totalCount}</span></p>',
                ]);


            }
            ?>

        </div>

    </div>
    <div class="tasks-form tab-pane fade in" id="page3">

    </div>
</div>