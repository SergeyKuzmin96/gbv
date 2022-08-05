<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 02.04.2019
 * Time: 21:41
 */

/**
 * @var $this View
 * @var $model Reviews
 */

use app\models\Reviews;
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
            <?= Html::submitButton('Отправить', [
                'class' => 'btn btn-primary'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>

    </div>
</div>