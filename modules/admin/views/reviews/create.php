<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Reviews */

$this->title = Yii::t('app', 'Add review');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
