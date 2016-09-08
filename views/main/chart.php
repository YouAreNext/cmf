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