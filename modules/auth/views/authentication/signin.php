<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 02.04.2019
 * Time: 21:41
 */

/**
 * @var $this \yii\web\View
 * @var $model User
 */

use app\modules\auth\models\User;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

//\app\modules\auth\asssets\AuthAsset::register($this);


?>

<div class="row">
    <div class="col-md-6 col-lg-offset-3">
        <?php $form = ActiveForm::begin([
            'method' => 'post'
        ]); ?>

        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group text-center">
            <?= Html::submitButton('Войти', [
                'class' => 'btn btn-primary'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <div class="form-group text-center">
            <p>Не проходили регистрацию?</p>
            <?= Html::a('Зарегестрироваться', 'signup') ?>
        </div>


    </div>
</div>
