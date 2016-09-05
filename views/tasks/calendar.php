<?php

use yii\helpers\Html;
use app\models\Tasks;
use yii\helpers\Url;
use kartik\select2\Select2;
use app\models\User;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use app\models\Projects;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TasksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;


?>


<div class="tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
    <!--        <?//= Html::a('Добавить задачу', ['create'], ['class' => 'btn btn-success right-button ']) ?>-->
    </p>
<!--    <div class="calendar-filter-block row">-->
<!--        <div class="col-md-3 calendar-user-select">-->
<!--            --><?php
//            $workers = User::find()->all();
//            $workers = \app\models\Profile::find()->all();
//            $items = ArrayHelper::map($workers,'user_id','first_name');
//
//            echo Select2::widget([
//                'name' => 'state_10',
//                'data' => $items,
//                'options' => [
//                    'placeholder' => 'Имя работника'
//                ],
//            ]);
//            ?>
<!--        </div>-->
<!--    </div>-->
    <div class="report-panel row">
        <?php $form = ActiveForm::begin([
            'action' => ['tasks/calendar'],
            'method' => 'get',
        ]);?>

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
        <div class="col-md-3">
            <?= $form->field($searchModel, 'worker')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\app\models\Profile::find()->all(),'user_id','first_name'),
                'options' => ['placeholder' => 'Исполнитель...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>

        <div class="col-md-3 report-calend">
            <?php
            echo DateRangePicker::widget([
                'name'=>'date_range_3',
                'attribute'=>'finish_date',
                'model'=>$searchModel,
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
        <div class="col-md-3 report-btn">
            <?= Html::submitButton('Сформировать отчет',['class' => 'btn btn-success'])?>
        </div>
        <?php ActiveForm::end()?>
    </div>
    <div class="calendar-wrap">
        <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
            'events'=> $events,
            'options' => [
                'lang' => 'ru',
            ]
        ));
        ?>
    </div>
</div>

<script>

</script>

