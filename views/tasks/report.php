<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Projects;
use yii\widgets\ListView;
use yii\helpers\StringHelper;
use kartik\daterange\DateRangePicker;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $model app\models\Tasks */

$this->title = 'Отчет по выполненным задачам';
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="report-panel">
    <?php $form = ActiveForm::begin([
        'action' => ['tasks/report?img=0'],
        'method' => 'get',
    ]);?>
    <div class="row">
        <div class="col-md-3"><?= $form->field($searchModel,'title')?></div>

        <div class="col-md-3">
            <?= $form->field($searchModel, 'project_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Projects::find()->all(),'id','Title'),
                'options' => ['placeholder' => 'Проект...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>

        <div class="col-md-3 report-calend date-report-form">
                <?php
                echo DateRangePicker::widget([
                    'name'=>'date_range_3',
                    'attribute'=>'finish_date',
                    'model'=>$searchModel,
                    'options' => ['placeholder' => 'Дедлайн','class'=>'form-control'],
                    'presetDropdown'=>TRUE,
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'locale'=>[
                            'format'=>'Y-m-d',
                            'separator'=>' to ',
                        ],
                        'opens'=>'left'
                    ]


                ]);
                ?>
        </div>
        <div class="col-md-3 report-calend date-report-form">
            <?php
            echo DateRangePicker::widget([
                'name'=>'date_range_3',
                'attribute'=>'task_complete',
                'model'=>$searchModel,
                'options' => ['placeholder' => 'Фактическое завершение','class'=>'form-control'],
                'presetDropdown'=>TRUE,
                'convertFormat'=>true,
                'pluginOptions'=>[
                    'locale'=>[
                        'format'=>'Y-m-d',
                        'separator'=>' to ',
                    ],
                    'opens'=>'left'
                ]


            ]);
            ?>
        </div>
    </div>
    <div class="row">

        <div class="col-md-3">
            <?= $form->field($searchModel, 'worker')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\app\models\Profile::find()->all(),'user_id','first_name'),
                'options' => ['placeholder' => 'Исполнитель...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($searchModel, 'task_creator')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\app\models\Profile::find()->all(),'user_id','first_name'),
                'options' => ['placeholder' => 'Задачу создал...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    </div>
    <div class="col-md-3 report-btn">
        <?= Html::submitButton('Сформировать отчет',['class' => 'btn btn-success'])?>
    </div>




    <?php ActiveForm::end()?>
</div>
<div style="clear:both"></div>
<div class="row">
    <div class="col-md-3">
        <div class="checkbox">
            <label><input class="img-check" type="checkbox" value="">Без картинок</label>
        </div>
    </div>
</div>
<div class="projects-form tab-pane" id="complete">
    <?php



    echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => function($dataProvider){
        $date = new DateTime();
        $date->setTimestamp($dataProvider->task_complete);
        $report_date = $date->format('Y-m-d H:i:s') . "\n";


        //Урл аватарки
        if(\app\models\Profile::find()->where(['user_id'=>$dataProvider->worker])->exists()){
            $avaUrl = \app\models\Profile::find()->where(['user_id'=>$dataProvider->worker])->one()->ava_url;
        } else{
            $avaUrl = 'web/uploads/avatars/crm-user.png';
        }
        //Имя исполнителя
        if(\app\models\Profile::find()->where(['user_id'=>$dataProvider->worker])->exists()){
            $userName = \app\models\Profile::find()->where(['user_id'=>$dataProvider->worker])->one()->first_name;
            $userLastName = \app\models\Profile::find()->where(['user_id'=>$dataProvider->worker])->one()->second_name;
        } else{
            $userName = 'Безымянный';
            $userLastName = '';
        }
        if(\app\models\Profile::find()->where(['user_id'=>$dataProvider->task_creator])->exists()){
            $CreatorName = \app\models\Profile::find()->where(['user_id'=>$dataProvider->task_creator])->one()->first_name;
            $CreatorLastName = \app\models\Profile::find()->where(['user_id'=>$dataProvider->task_creator])->one()->second_name;
        } else{
            $CreatorName = 'Безымянный';
            $CreatorLastName = '';
        }

    return '
    <div class="report-img col-md-3">
        <img src="/'.
        $avaUrl
        .
        '
        " alt="">
    </div>
    <div class="report-info-block col-md-9">
        <div class="report-panel-for">

            <div class="report-worker">
                '.$userName.' '.$userLastName.'
            </div>
            <div class="report-creator report-worker">
                '.$CreatorName.' '.$CreatorLastName.'
            </div>
            <div class="report-finish-date">
                '.$report_date.'
            </div>

        </div>
        <a href="/tasks/update?id='.$dataProvider->id.'" class="report-item-title">
            '.$dataProvider->title.'
        </a>
        <div class="report-desc">
        '.$dataProvider->description.'
        </div>
        <div class="report-comment">
        '.$dataProvider->worker_comment.'
        </div>
        <div class="report-item-date report-deathline">
        '.$dataProvider->finish_date.'
        <span class="glyphicon glyphicon-calendar"></span>
        </div>
        <div style="clear:both"></div>

    </div>
    ';
    },
    'options' => [
    'tag' => 'div',
    'class' => 'report-box',
    ],
    'itemOptions' => [
    'tag' => 'div',
    'class' => 'report-item row',
    ],
    'emptyText' => '<p>Нет подобных задач</p>',
    'emptyTextOptions' => [
    'tag' => 'p'
    ],
    'summary' => '<p class="total-task">Всего задач: <span class="bold-span">{totalCount}</span></p>',
    ]);
   ?>
</div>

<script>
    $(window).ready(function(){
        $(".img-check").on("change",function(){
           if($(this).is(':checked')){
               $(".report-img").hide();
           }else{
               $(".report-img").show();
           }
        });
    })
</script>