<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CommentImage */

$this->title = Yii::t('app', 'Create Comment Image');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comment Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
