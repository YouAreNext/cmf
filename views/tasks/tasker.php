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
    <div class="tab-content">
        <div class="projects-form tab-pane fade in active " id="active">

<!--            --><?php
//                $gridColumns = [
//                    'title',
//                    'description:text',
//                    'finish_date',
//                ];
//
//
//            echo ExportMenu::widget([
//                'dataProvider'=>$dataProvider,
//                'columns'=>$gridColumns
//            ])
//
//            ?>


            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'hover' => true,

                'columns' => [

                    'title',
                    'description:text',

                    [
                        'attribute' => 'worker',
                        'value' => 'user.username'
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
                                'format'=>'Y-m-d',
                                'opens'=>'left'
                            ]
                        ])

                    ],

                    [
                        'attribute'=>'project_id',
                        'value'=>'project.Title'
                    ],
                    ['class' => 'kartik\grid\ActionColumn'],
                ],
            ]); ?>

        </div>
        <div class="projects-form tab-pane fade" id="complete">
            <?= GridView::widget([
                'dataProvider' => $dataProvider2,
                'filterModel' => $searchModel2,
                'responsive'=>true,

                'columns' => [

                    'title',
                    'description:text',
                    [
                        'attribute' => 'worker',
                        'format' => 'text',
                        'label' => 'Исполнитель',
                        'value' => 'user.username'
                    ],
                    [
                        'attribute'=>'finish_date',
                        'value'=>'finish_date',
                        'filterType' => GridView::FILTER_DATE_RANGE,
                        'filterWidgetOptions' =>([
                            'model'=>$dataProvider2,
                            'attribute'=>'finish_date',
                            'presetDropdown'=>TRUE,
                            'convertFormat'=>true,
                            'pluginOptions'=>[
                                'format'=>'Y-m-d',
                                'opens'=>'left'
                            ]
                        ])

                    ],

                    [
                        'attribute'=>'project_id',
                        'value'=>'project.Title',

                    ],


                    ['class' => 'kartik\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>
