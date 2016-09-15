<?php
/**
 * Created by PhpStorm.
 * User: YouNext
 * Date: 29.04.2016
 * Time: 6:39
 */

use \yii\helpers\Html;
use dosamigos\highcharts\HighCharts;
use app\models\Projects;
use app\models\Tasks;
?>


<?php
    $Tasks = Tasks::find()->all();
    $TasksUserCount = \app\models\User::find()->count();
    $TaskArr = [];
    $TaskSlave = [];

    foreach($Tasks as $tasks){
        $TaskArr[$tasks->worker] = isset($TaskArr[$tasks->worker])?($TaskArr[$tasks->worker] + 1):0;
    }
    foreach($Tasks as $tasks){
        $TaskSlave[$tasks->task_creator] = isset($TaskSlave[$tasks->task_creator])?($TaskSlave[$tasks->task_creator] + 1):0;
    }
    $res = array_flip($TaskArr);

//    $res2 = array_flip($TaskSlave);
    $userMax = ($res[max($TaskArr)]);
    $userMaxTask = ($TaskArr[$userMax]);
//    $userMax2 = ($res[max($TaskSlave)]);

    $userMaxTitle = \app\models\Profile::find()->where(['user_id'=>$userMax])->one()->first_name;
 //   $userMaxTitle2 = \app\models\Profile::find()->where(['user_id'=>$userMax2])->one()->first_name;



?>

<div class="statistic-block">
    Лучший работник: <?=$userMaxTitle?> - <?=$userMaxTask?>
</div>




<?php
    $projects = Projects::find()->where(['seo_type'=>[0,1,2,3]])->all();
    $pew = array();
    foreach($projects as $project){
        $da = $project->Title;
        $TaskCount = Tasks::find()->where(["project_id"=>$project->id])->count();
        $pew[] = array(
                    "name" => $da,
                    "data" => array(floatval($TaskCount))
                );
        //['name' => 'Jane', 'data' => [1,2,3,4]],
    }


?>

<?= HighCharts::widget([
    'clientOptions' => [
        'chart' => [
            'type' => 'column'
        ],
        'title' => [
            'text' => 'Выполненные задачи'
        ],
        'xAxis' => [

            'categories' => [
                'Проекты',
            ]
        ],
        'yAxis' => [
            'title' => [
                'text' => 'Количество задач'
            ],

        ],
        'series' => $pew
    ]
]);

