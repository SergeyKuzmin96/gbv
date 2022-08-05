<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
$this->title = Yii::t('app', 'Update User') . ' № ' . $model->id;


$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
