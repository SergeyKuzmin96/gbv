<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Comments */
$this->title = Yii::t('app', 'Update Comment') . ' № ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="comment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
