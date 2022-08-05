<?php

use app\components\ImageLoaderComponent;
use app\models\CommentsImages;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CommentsImages */

$this->title = Yii::t('app', 'Image') .' № '.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comment Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="comment-image-view">

    <p>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'comment',
                'label' => Yii::t('app', 'Comment'),
                'value' => function (CommentsImages $model) {
                    $url = '../../admin/comments/view/?id=' . $model->comment_id;
                    return Html::a($model->getCommentMessage(), $url);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'path',
                'label' => Yii::t('app', 'File name'),

            ],

            [
                'attribute' => 'image',
                'label' => Yii::t('app', 'Image'),
                'value' => function ($model) {
                    $comp = new ImageLoaderComponent();
                    return $comp->getOneImage($model->path, 220, 170);
                },
                'format' => 'raw'
            ],

            [
                'attribute' => 'date_add',
                'label' => Yii::t('app', 'Date add')
            ],
        ],
    ]) ?>

</div>
