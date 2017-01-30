<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use app\models\User;

    /* @var $this yii\web\View */
    /* @var $model app\models\Profile */
    /* @var $form ActiveForm */
?>



<div class="main-profile">
    <img class="profile-ava" src="/<?=$model->ava_url?>" alt="">
    <?php $form = ActiveForm::begin
        (['options'=>['enctype'=>'multipart/form-data']]);
    ; ?>
        <?= $form->field($model, 'avatar')->fileInput()?>
        <?= $form->field($model, 'first_name') ?>
        <?= $form->field($model, 'second_name') ?>
        <?= $form->field($model, 'middle_name') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'job_position')->dropDownList([
            '1' => 'SEO-специалист',
            '2' => 'Разработчик',
            '3' => 'Менеджер'
        ]);?>
    
        <div class="form-group">
            <?= Html::submitButton('Редактировать', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- main-profile -->
