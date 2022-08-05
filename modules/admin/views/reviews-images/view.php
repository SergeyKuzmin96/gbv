<?php

use app\components\ImageLoaderComponent;
use app\models\ReviewsImages;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ReviewsImages */

$this->title = Yii::t('app', 'Image') .' № '.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Review Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="review-image-view">


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
                'attribute' => 'review',
                'label' => Yii::t('app', 'Review'),
                'value' => function (ReviewsImages $model) {
                    $url = '../../admin/reviews/view/?id=' . $model->review_id;
                    return Html::a($model->getReviewMessage(), $url);
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
