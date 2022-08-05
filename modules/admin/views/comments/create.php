<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Comments */

$this->title = Yii::t('app', 'Add comment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
