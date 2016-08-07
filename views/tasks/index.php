<?php

use yii\helpers\Html;
use kartik\grid\GridView;

use app\models\Tasks;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TasksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Мои задачи';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить задачу', ['create'], ['class' => 'btn btn-success right-button ']) ?>
    </p>
    <ul class="nav nav-pills">
        <li class="active"><a data-toggle="tab" href="#active">Активные</a></li>
        <li><a data-toggle="tab" href="#complete">Выполненные</a></li>

    </ul>
    <div class="tab-content">
        <div class="projects-form tab-pane fade in active " id="active">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'pjax'=>true,

                'columns' => [


                    // 'id',

//                    [
//                        'attribute' => 'Title',
//                        'value' => function (Tasks $model) {
//                            return Html::a(Html::encode('Перейти'), Url::to(['update', 'id' => $model->id]));
//                        },
//                        'format' => 'raw',
//
//                    ],
                    'title',

                    'description:text',
//                    [
//                        'attribute'=>'Дата окончания',
//                        'value'=>'task_complete',
//                        'format'=>'raw',
//                        'filter'=>DatePicker::widget([
//                            'model' => $searchModel,
//                            'attribute' => 'date_from',
//                            'attribute2' => 'date_to',
//                            'options' => ['placeholder' => 'Start date'],
//                            'options2' => ['placeholder' => 'End date'],
//                            'type' => DatePicker::TYPE_RANGE,
//
//                            'pluginOptions' => [
//                                'format' => 'yyyy-mm-dd',
//                                'autoclose' => true,
//                            ]
//                        ])
//                    ],

//             [
//
//                'attribute' => 'worker',
//                'format' => 'text',
//                'label' => 'Исполнитель',
//
//            ],
                    //'Status',

                    [
                        'attribute'=>'project_id',
                        'value'=>'project.Title'

                    ],
                    'finish_date',

                    // 'created_at',
                    // 'finish_date',
                    // 'task_complete',
                    // 'project_id',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
        <div class="projects-form tab-pane fade" id="complete">
            <?= GridView::widget([
                'dataProvider' => $dataProvider2,
                'filterModel' => $searchModel2,
                'pjax'=>true,
                'columns' => [


                    // 'id',

//                    [
//                        'attribute' => 'Title',
//                        'value' => function (Tasks $model) {
//                            return Html::a(Html::encode('Перейти'), Url::to(['update', 'id' => $model->id]));
//                        },
//                        'format' => 'raw',
//
//                    ],
                    'title',
                    'description:text',
//             [
//
//                'attribute' => 'worker',
//                'format' => 'text',
//                'label' => 'Исполнитель',
//
//            ],
                    //'Status',

                    [
                        'attribute'=>'project_id',
                        'value'=>'project.Title'

                    ],
                    'finish_date',

                    // 'created_at',
                    // 'finish_date',
                    // 'task_complete',
                    // 'project_id',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>
