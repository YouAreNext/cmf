<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Проекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


        <?= Html::a('Создать проект', ['create'], ['class' => 'btn btn-success right-button']) ?>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'Title',
            'site_addr',
            [
                'label'=>'Тип проекта',
                'format'=>'text',
                'attribute'=>'seo_type',
                'value'=>function($model){
                   switch($model->seo_type){
                       case 0:
                           return 'Обслуживание';
                       case 1:
                           return 'Минимальный';
                       case 2;
                           return 'Стандартный';
                       case 3:
                           return 'Максимальный';
                       case 4:
                           return 'Директ';
                       case 5:
                           return 'Разработка';
                       case 6:
                           return 'Менеджмент';

                   }

                },
                'filter'=>array(
                    "0"=>"Обслуживание",
                    "1"=>"Минимальный",
                    "2"=>"Стандартный",
                    "3"=>"Максимальный",
                    "4"=>"Директ",
                    "5"=>"Разработка",
                    "6"=>"Менеджмент",
                ),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end()?>
</div>
