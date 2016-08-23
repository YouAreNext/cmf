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

    <div class="popup-task-img">
        <img src="/<?=$TaskWorkerImg?>" alt="">
    </div>
    <div class="popup-task-info">
        <div class="popup-task-worker">
            <?=$TaskWorkerName?>
        </div>
        <div class="popup-task-project">
            <?=$TaskProject?>
        </div>
    </div>

