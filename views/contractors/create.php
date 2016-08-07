<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Contractors */

$this->title = 'Create Contractors';
$this->params['breadcrumbs'][] = ['label' => 'Contractors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contractors-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
