<?php

use yii\helpers\Html;
use app\models\Tasks;


/* @var $this yii\web\View */
/* @var $model app\models\Tasks */
/* @var $pews */

$this->title = 'Обзор задачи: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обзор задачи';


$thisProject = $model->id;



?>


<div class="tasks-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="btn btn-success right-button add-task-sub" data-id=<?php echo $model->id ?>>
        Добавить подзадачу
    </div>

    <div style="clear:both"></div>
    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>

</div>
