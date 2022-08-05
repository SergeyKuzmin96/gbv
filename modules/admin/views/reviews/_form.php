<?php

use app\models\Users;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Reviews */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="review-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'message')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'images[]')->fileInput(['multiple' => true, 'accept' => 'image/*']); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', Yii::t('app','Save')), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
