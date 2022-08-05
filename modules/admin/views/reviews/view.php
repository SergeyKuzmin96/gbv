<?php

use app\components\ImageLoaderComponent;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Reviews */

$this->title = Yii::t('app', 'Review') . ' №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="review-view">


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
                'attribute' => 'message',
                'label' => Yii::t('app', 'Review')
            ],
            [
                'attribute' => 'date_add',
                'label' => Yii::t('app', 'Date add')
            ],
            [
                'attribute' => 'images',
                'value' => function ($model) {
                    $comp = new ImageLoaderComponent();
                    $images = '';
                    foreach ($model->reviewsImages as $image) {
                        $images .= $comp->getOneImage($image->path, 100 , 75);
                    }
                    if (empty($images)) {
                        return 'Изображения отсутствуют';
                    }
                    return $images;
                },
                'format' => 'raw'
            ],
        ],
    ]) ?>

</div>
