<?php


/* @var $this View */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

?>
<div class="row">
    <div class="col-md-6 col-lg-offset-3">
        <?php
        Pjax::begin([
            'enablePushState' => false,
        ]); ?>
        <?php
        $form = ActiveForm::begin([
            'method' => 'post'
        ]); ?>

        <?= $form->field($model, 'message')->textarea() ?>
        <?= $form->field($model_img, 'images[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
        <div class="form-group text-center">
            <?= Html::submitButton('Отправить', [
                'class' => 'btn btn-primary'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>


    </div>
</div>