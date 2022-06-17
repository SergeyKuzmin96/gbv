<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReviewImage */

$this->title = Yii::t('app', 'Create Review Image');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Review Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
