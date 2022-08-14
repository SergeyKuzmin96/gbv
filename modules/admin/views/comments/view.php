<?php

use app\components\ImageLoaderComponent;
use app\models\Comments;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Comments */

$this->title = Yii::t('app', 'Comment') . ' №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="comment-view">


    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'users.email',
            [
                'attribute' => 'review',
                'label' => Yii::t('app', 'Review'),
                'value' => function (Comments $model) {
                    $url = '../../admin/reviews/view/?id=' . $model->review_id;
                    return Html::a($model->getReviewMessage(), $url);
                },
                'format' => 'raw'
            ],

            [
                'attribute' => 'message',
                'label' => Yii::t('app', 'Comment')
            ],
            [
                'attribute' => 'images',
                'value' => function (Comments $model) {
                    $comp = new ImageLoaderComponent();
                    $images = '';
                    foreach ($model->commentsImages as $image) {
                        $images .= $comp->getOneImage($image->path, 100, 75);
                    }
                    if (empty($images)) {
                        return 'Изображения отсутствуют';
                    }
                    return $images;
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
