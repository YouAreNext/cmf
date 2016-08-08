<?php

use yii\widgets\ListView;
use yii\widgets\BaseListView;
use yii\helpers\StringHelper;
use app\models\Tasks;
use yii\data\ActiveDataProvider;
use app\models\User;

$userName = Yii::$app->user->identity['username'];
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

    <h2>
        Ну, здравствуй <?=$userName?>!
    </h2>

<?php

$userId = Yii::$app->user->identity['id'];



$query = Tasks::find()->andFilterWhere([
    'Status'=>1,
    'worker'=>$userId
]);
$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'sort' => [
        'defaultOrder' =>['finish_date'=>SORT_ASC]
    ],

]);

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => function($dataProvider){
        return '
            <div class="task-box clearfix">
                <div class="task-header">
                '.$dataProvider->title.'
                </div>
                <div class="task-text">
                '.StringHelper::truncate($dataProvider->description, 100).'

                </div>
                <div class="task-finish-date clearfix">Дата окончания:'.$dataProvider->finish_date.'</div>
                <div style="clear:both"></div>
                <a href="tasks/update?id='.$dataProvider->id.'" class="task-link">
                Перейти
                </a>

            </div>
            ';
    },
    'options' => [
        'tag' => 'div',
        'class' => 'list-box-main',
    ],
    'itemOptions' => [
        'tag' => 'div',
        'class' => 'list-box-item',
    ],
    'emptyText' => '<p>У тебя нет задач, ты бесполезен</p>',
    'emptyTextOptions' => [
        'tag' => 'p'
    ],
    'summary' => '<p class="total-task">Всего задач: <span class="bold-span">{totalCount}</span></p>',
]);

?>