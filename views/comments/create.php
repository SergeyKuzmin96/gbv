<?php


/* @var $this View
 * @var $model Comments
 */

use app\models\Comments;
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
            'timeout' => 10000,
        ]); ?>
        <?php
        $form = ActiveForm::begin([
            'method' => 'post'
        ]); ?>

        <?= $form->field($model, 'message')->textarea() ?>
        <?= $form->field($model, 'images[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
        <div class="form-group text-center">
            <?= Html::submitButton(Yii::t('app','Add Comment'), [
                'class' => 'btn btn-primary'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>


    </div>
</div>