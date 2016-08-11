<?php

use yii\helpers\Html;
use app\models\Tasks;
use app\models\Profile;

/* @var $this yii\web\View */
/* @var $model app\models\Tasks */
/* @var $pews */

$this->title = 'Обзор задачи: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обзор задачи';


$thisProject = $model->id;
$userId = Yii::$app->user->identity['id'];
$TaskCreator = $model->task_creator;

?>


<div class="tasks-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="task-creator">
    Задачу назначил(а):<?php
        if (isset(Profile::find()->where(['user_id'=>$TaskCreator])->one()->first_name)) {
            echo '&nbsp' .Profile::find()->where(['user_id'=>$TaskCreator])->one()->first_name.'&nbsp '.
                Profile::find()->where(['user_id'=>$TaskCreator])->one()->second_name;
        }
        ?>
    </div>
    <div class="btn btn-success right-button add-task-sub" data-id=<?php echo $model->id ?>>
        Добавить подзадачу
    </div>

    <div style="clear:both"></div>
    <?= $this->render('_form', [
        'model' => $model,
        'userId'=>$userId
    ]) ?>

</div>
