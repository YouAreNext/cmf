<?php

use yii\helpers\Html;
use app\models\Tasks;
use app\models\TasksSearch;
/* @var $this yii\web\View */
/* @var $model app\models\Projects */

$this->title = 'Обзор проекта: ' . $model->Title;
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Обзор проекта';



?>
<div class="projects-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'FileModel'=>$FileModel,
        'dataFile'=>$dataFile
    ]) ?>

</div>
