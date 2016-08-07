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
                <?= $form->field($model, 'seo_type')->dropDownList([
                    '0' => 'Обслуживание',
                    '1' => 'Минимальный',
                    '2' => 'Стандартный',
                    '3' => 'Максимальный',
                ]) ?>
                <?= $form->field($model, 'seo_theme')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
                <?= $form->field($model, 'Commentary')->textarea(['rows' => 6]) ?>
            </div>
        </div>
        <div class="container-fluid spoiler">




        </div>





        <div class="form-group right-button">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
        <div id="hide-me" class="collapse">
            <div class="todo-list">
                Привет
            </div>
        </div>

        <?php $form = ActiveForm::begin([
            'enableAjaxValidation'      => true,
            'enableClientValidation'    => false,
            'validateOnChange'          => false,
            'validateOnSubmit'          => true,
            'validateOnBlur'            => false,
        ]);?>

        <?= $form->field($model, 'emails')->widget(MultipleInput::className(), [
            'limit' => 4,
        ]);
        ?>

        <?= Html::submitButton('Update', ['class' => 'btn btn-success']);?>

        <?php ActiveForm::end();?>



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