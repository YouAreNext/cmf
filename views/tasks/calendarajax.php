<?php

use yii\helpers\Html;
use app\models\Tasks;
use yii\helpers\Url;
use kartik\select2\Select2;
use app\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TasksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;


?>


    <div class="calendar-wrap">
        <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
            'events'=> $events,
            'options' => [
                'lang' => 'ru',
            ]
        ));
        ?>
    </div>


