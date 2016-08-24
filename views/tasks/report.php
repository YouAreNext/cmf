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
/* @var $this yii\web\View */
/* @var $model app\models\Tasks */

$this->title = 'Отчет по выполненным задачам';
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="report-panel row">
    <?php $form = ActiveForm::begin([
        'action' => ['tasks/report?img=0'],
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
        if(\app\models\Profile::find()->where(['user_id'=>$dataProvider->worker])->exists()){
            $avaUrl = \app\models\Profile::find()->where(['user_id'=>$dataProvider->worker])->one()->ava_url;
        } else{
            $avaUrl = 'web/uploads/avatars/crm-user.png';
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
        <a href="/tasks/update?id='.$dataProvider->id.'" class="report-item-title">
            '.$dataProvider->title.'
        </a>
        <div class="report-desc">
        '.$dataProvider->description.'
        </div>
        <div class="report-comment">
        '.$dataProvider->worker_comment.'
        </div>
        <div class="report-item-date">
        '.$dataProvider->finish_date.'
        <span class="glyphicon glyphicon-calendar"></span>
        </div>
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