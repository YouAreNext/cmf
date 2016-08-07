<?php

use yii\helpers\Html;
use app\models\Tasks;
use yii\helpers\Url;


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
        <?= Html::a('Добавить задачу', ['create'], ['class' => 'btn btn-success right-button ']) ?>
    </p>
    <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
        'events'=> $events,
        'options' => [
            'lang' => 'ru',

        ]
    ));
    ?>
</div>
