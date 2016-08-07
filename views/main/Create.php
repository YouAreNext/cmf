<?php
/**
 * Created by PhpStorm.
 * User: YouNext
 * Date: 29.04.2016
 * Time: 6:39
 */

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?=$form->field($model,'title')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?=$form->field($model,'title')->textInput() ?>
        </div>
        <div class="col-md-12">
            <?= Html::submitButton('Создать',['class'=>'btn btn-success']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
