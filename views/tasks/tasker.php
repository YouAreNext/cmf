<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\User;
use app\models\Projects;
use app\models\Tasks;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
use kartik\daterange\DateRangePicker;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TasksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
$workers = User::find()->all();
?>
<div class="tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить задачу', ['create'], ['class' => 'btn btn-success right-button']) ?>
    </p>

    <ul class="nav nav-pills">
        <li class="active"><a data-toggle="tab" href="#active">Активные</a></li>
        <li><a data-toggle="tab" href="#complete">Выполненные</a></li>
    </ul>
    <?php

        $gridColumns = [
            'title',
            'finish_date',
            [
                'attribute'=>'worker',
                'value'=>'user.username'
            ],
            'description',
            'worker_comment'
        ];
        echo ExportMenu::widget([
            'dataProvider' => $dataProvider2,
            'columns' => $gridColumns
        ])

    ?>
    <div class="tab-content">
        <div class="projects-form tab-pane fade in active " id="active">

            <?php
                $workers = User::find()->all();
            ?>



            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function($model){
                    switch($model->task_priority){
                        case 1:
                            return ['class'=>'task-priority'.$model->task_priority];
                        case 2:
                            return ['class'=>'task-priority'.$model->task_priority];
                        case 3:
                            return ['class'=>'task-priority'.$model->task_priority];
                    }
                },
                'columns' => [

                    'title',

                    [
                        'attribute'=>'worker',
                        'value'=>'user.username',
                        'filter'=>ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username'),

                    ],

                    [
                        'attribute'=>'finish_date',
                        'value'=>'finish_date',
                        'filterType' => GridView::FILTER_DATE_RANGE,
                        'filterWidgetOptions' =>([
                            'model'=>$searchModel,
                            'attribute'=>'finish_date',
                            'presetDropdown'=>TRUE,
                            'convertFormat'=>true,

                            'pluginOptions'=>[
                                'locale'=>[
                                    'format'=>'Y-m-d',
                                    'separator'=>' to ',
                                ],
                                'opens'=>'left'
                            ]

                        ])

                    ],
//                    [
//                        'attribute'=>'finish_date',
//                        'value'=>'finish_date',
//                        'filter'=>DatePicker::widget([
//                            'model' => $searchModel,
//                            'attribute' => 'date_from',
//                            'attribute2' => 'date_to',
//                            'options' => ['placeholder' => 'Start date'],
//                            'options2' => ['placeholder' => 'End date'],
//                            'type' => DatePicker::TYPE_RANGE,
//                            'pluginOptions' => [
//                                'format' => 'yyyy-mm-dd',
//                                'autoclose' => true,
//                            ]
//                        ])
//                    ],

                    [
                        'attribute'=>'project_id',
                        'value'=>'project.Title',
                        'filter'=>Select2::widget([
                            'attribute'=>'project_id',
                            'model' => $searchModel,
                            'data' => ArrayHelper::map(Projects::find()->all(),'id','Title'),

                            // ... other params
                            'options' => ['placeholder' => 'Проект...'],
                        ]),

                        'width'=>'200px'
                    ],

                    [
                        'label' =>'',
                        'value' => function ($model)
                        {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['update', 'id' => $model->id],$options = ['class'=>'link-to-task']);

                        },
                        'format'=>'raw',
                    ],
                ],
            ]); ?>

        </div>
        <div class="projects-form tab-pane fade" id="complete">
            <?= GridView::widget([
                'dataProvider' => $dataProvider2,
                'filterModel' => $searchModel2,
                'responsive'=>true,
                'rowOptions' => function($model){
                    switch($model->task_priority){
                        case 1:
                            return ['class'=>'task-priority'.$model->task_priority];
                        case 2:
                            return ['class'=>'task-priority'.$model->task_priority];
                        case 3:
                            return ['class'=>'task-priority'.$model->task_priority];
                    }
                },
                'columns' => [

                    'title',

                    [
                        'attribute'=>'worker',
                        'value'=>'user.username',
                        'filter'=>ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username'),

                    ],
                    [
                        'attribute'=>'finish_date',
                        'value'=>'finish_date',
                        'filterType' => GridView::FILTER_DATE_RANGE,
                        'filterWidgetOptions' =>([
                            'model'=>$searchModel,
                            'attribute'=>'finish_date',
                            'presetDropdown'=>TRUE,
                            'convertFormat'=>true,
                            'pluginOptions'=>[
                                'locale'=>[
                                    'format'=>'Y-m-d',
                                    'separator'=>' to ',
                                ],
                                'opens'=>'left'
                            ]

                        ])

                    ],

                    [
                        'attribute'=>'project_id',
                        'value'=>'project.Title',
                    ],

                    [
                        'label' =>'',
                        'value' => function ($model)
                        {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['update', 'id' => $model->id],$options = ['class'=>'link-to-task']);

                        },
                        'format'=>'raw',
                    ],
                ],
            ]); ?>
        </div>

    </div>

</div>
