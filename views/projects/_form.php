<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\models\Tasks;
use app\models\TasksSearch;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use unclead\widgets\MultipleInput;
use kartik\file\FileInput;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Projects */
/* @var $form yii\widgets\ActiveForm */



$thisProject = $model->id;

$searchModel = new TasksSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider->query->andFilterWhere(['project_id' => $thisProject ]);



?>

<ul class="nav nav-tabs nav-justified">
    <li class="active"><a data-toggle="tab" href="#home">Проект</a></li>
    <li><a data-toggle="tab" href="#props">Дополнительно</a></li>
    <li><a data-toggle="tab" href="#menu1">Задачи</a></li>
    <li><a data-toggle="tab" href="#menu2">Файлы</a></li>
</ul>

<div class="tab-content tab-content-projects clearfix">
    <div class="projects-form tab-pane fade in active" id="home">

        <?php $form = ActiveForm::begin([
            'options'=>['enctype'=>'multipart/form-data']
        ]); ?>
        <div class="row">

            <div class="col-md-6">
                <?= $form->field($model, 'Title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'site_addr')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?php
                $workers = User::find()->all();
                $items = ArrayHelper::map($workers,'id','username');
                $params = [
                    'prompt' => 'Ответственный за проект'
                ];
                echo $form->field($model, 'project_chief')->dropDownList($items,$params);
                ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'report_day')->widget(
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
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'seo_type')->dropDownList([
                    '0' => 'Обслуживание',
                    '1' => 'Минимальный',
                    '2' => 'Стандартный',
                    '3' => 'Максимальный',
                ]) ?>

            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'seo_theme')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <?= $form->field($model, 'Commentary')->textarea(['rows' => 6]) ?>
            </div>

        </div>

        <div class="form-group right-button">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>



        <div class="row">
            <div class="col-md-12">
                <h2>Периодические задачи</h2>
                <div class="btn btn-success  add-task-period" data-id=<?=$model->id?>>
                    Добавить периодическую задачу
                </div>
            </div>
        </div>
       <div class="row">
            <?php

            $dataPeriodQuery = Tasks::find()->andFilterWhere([
               'project_id' => $model->id,
                'periodic' => 1
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
                    <a href="/tasks/update?id='.$dataPeriod->id.'" class="period-task-item col-md-8">
                        '.$dataPeriod->title.'
                    </a>
                    <div class="period-task-date col-md-4 "><span class="glyphicon glyphicon-calendar"></span>'.$dataPeriod->finish_date.' </div>
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
                'emptyText' => '<p>Нет периодических задач</p>',
                'emptyTextOptions' => [
                    'tag' => 'p'
                ],
                'summary' => '<p class="total-task">Всего задач: <span class="bold-span">{totalCount}</span></p>',
            ]);



            ?>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="projects-form tab-pane fade" id="props">
        <div class="btn btn-info collapsed" data-toggle="collapse" data-target="#hide-me2" aria-expanded="false">
            <span class="glyphicon glyphicon-chevron-down"></span>
            Контрагенты</div>
        <div id="hide-me2" class="collapse">

        </div>
        <div class="btn btn-info collapsed" data-toggle="collapse" data-target="#hide-me" aria-expanded="false">
            <span class="glyphicon glyphicon-chevron-down"></span>
            Чек-Лист</div>
        <div id="hide-me" class="collapse in">
            <div class="todo-list">

            </div>
            <div class="btn btn-success check-confirm" data-id=<?=$model->id?> >Обновить</div>
        </div>


    </div>
    <div id="menu1" class="tab-pane fade">
        <div class="btn btn-success right-button add-task-project" data-date=<?php echo date('Y-m-d')?>>
            Добавить задачу
        </div>

        <?php Pjax::begin()?>
        <?= GridView::widget([

            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,

            'columns' => [


                // 'id',

                [
                    'attribute' => 'Title',
                    'value' => function (Tasks $model) {
                        return Html::a(Html::encode($model->title), Url::to(['update', 'id' => $model->id]));
                    },
                    'format' => 'raw',

                ],
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

                'project.Title',

                // 'created_at',
                // 'finish_date',
                // 'task_complete',
                // 'project_id',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end()?>

    </div>
    <div id="menu2" class="tab-pane fade">
        <h3>Файлы</h3>


    </div>

</div>

<script>
    function parseUrlQuery() {
        var data = {}
            ,   pair = false
            ,   param = false;
        if(location.search) {
            pair = (location.search.substr(1)).split('&');
            for(var i = 0; i < pair.length; i ++) {
                param = pair[i].split('=');
                data[param[0]] = param[1];
            }
        }
        return data;
    }
    $.ajax({
        url: 'update?id='+parseUrlQuery().id,
        type: "GET",
        dataType: 'json',

        success: function (data) {

            $(data.checkItem).each(function(indx){
                console.log(data.checkItem);
                //console.log(indx);
                //console.log($(data.checkItem)[indx].content);

                $(".todo-list").append('<div class="todo-item">' +
                    '<div class="todo-bg"></div>' +
                    '<div class="todo-check glyphicon glyphicon-ok"></div>' +
                    '<input type="text" class="todo-inp">' +
                    '<div class="todo-delete glyphicon glyphicon-remove"></div>' +
                    '</div>'
                );


                if(indx == 0){
                    $(".todo-delete").addClass("todo-action").removeClass("glyphicon-remove").removeClass("todo-delete")
                        .addClass("glyphicon-plus");
                }
                if (data.checkItem[indx].check == 1){
                    //console.log(data.checkItem[indx].check);
                    $(".todo-item").eq(indx).addClass("todo-checked");
                }

                $(".todo-inp").eq(indx).val(data.checkItem[indx].content);
                //console.log(data.checkItem[indx].content);
            });

        },
        error: function () {
            console.log("error");
            if($(".todo-item").length == 0){
                console.log("pew");
                $(".todo-list").append('<div class="todo-item">' +
                    '<div class="todo-bg"></div>' +
                    '<div class="todo-check glyphicon glyphicon-ok"></div>' +
                    '<input type="text" class="todo-inp">' +
                    '<div class="todo-action glyphicon glyphicon-plus"></div>' +
                    '</div>'
                );
            }else{
                console.log($(".todo-item").length);
            }
        }
    })
</script>