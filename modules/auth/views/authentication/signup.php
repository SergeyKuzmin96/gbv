<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 01.04.2019
 * Time: 23:31
 */

/**
 * @var $model User
 */

use app\modules\auth\models\User;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html; ?>

<div class="row">
    <div class="col-md-6 col-lg-offset-3">
        <?php $form = ActiveForm::begin([
            'method' => 'post'
        ]); ?>

        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group text-center">
            <?= Html::submitButton('Регистрация', [
                'class' => 'btn btn-primary'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <div class="form-group text-center">
            <p>У вас есть аккаунт?</p>
            <?= Html::a('Войти', 'signin') ?>
        </div>

    </div>
</div>