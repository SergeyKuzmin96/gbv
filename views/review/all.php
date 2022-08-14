<?php

/* @var $reviews Reviews
 * @var $count integer
 */

use app\models\Reviews;
use yii\bootstrap4\Modal;
use yii\widgets\Pjax;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;

?>


<?php Pjax::begin([
    'enablePushState' => false,
    'timeout' => 10000,
]); ?>
<?php if (!Yii::$app->user->isGuest): ?>
    <?= Html::a(Yii::t('app', 'Leave review'), ['review/create'], ['class' => 'btn btn-xs btn-outline-primary']) ?>
    <hr>
<?php endif; ?>
<?php Pjax::end(); ?>
<br>

<?php Pjax::begin([
    'enablePushState' => false,
]); ?>

<div class ="parent" id="reviews" data-count= "<?= count($reviews) ?>">

    <?php if (count($reviews) == 0): ?>
        <h3><?php echo Yii::t('app', 'No reviews have been left so far') ?></h3>
    <?php else: ?>
        <h3><?php echo Html::tag('strong', Yii::t('app', 'Reviews')) . ' : ' ?></h3>
        <hr>
        <hr>
    <?php endif; ?>

    <?php foreach ($reviews as $review): ?>
        <div class="review border border-success">
            <?= Html::tag('p', Html::tag('strong', '№ ' . $review->id)) ?>
            <?= Html::tag('p', Html::tag('strong', Yii::t('app', 'Author')) . ' : ' . $review->users->email) ?>
            <p><?php echo Html::tag('strong', Yii::t('app', 'Review')) . ' : ' ?><?= Html::encode($review->message) ?> </p>

            <?php $images = $review->reviewsImages; ?>
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $image): ?>
                    <ul>
                        <li><?= Html::img('/images/' . $image->path, ['width' => 150, 'height' => 120]) ?></li>
                    </ul>
                <?php endforeach; ?>
            <?php endif; ?>
                <?php if ((\Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin')) || (Yii::$app->user->id == $review->users->id)): ?>

                    <hr>
                    <?= Html::a(Yii::t('app', 'Add Comment'), ['comments/create', 'id' =>$review->id], ['class' => 'btn btn-xs btn-outline-primary']) ?>
                    <hr>

                <?php endif; ?>
            <br>
            <div class = "comments"  data-content="<?= $review->id ?>" data-count= "0"></div>

            <button class="btn get_comments btn-outline-info"
                    id="get_comments" data-attr="<?= $review->id ?>"
                    type="button">
                <?php echo Yii::t('app','Comments') ?>
            </button>

        </div>
        <hr>
        <hr>
    <?php endforeach; ?>
</div>
<?php Pjax::end(); ?>
<br>
<?php if ($countAll > 5): ?>
    <div class="container">
        <form class="form">
            <button class="btn btn-outline-info" id="review"
                    type="submit"><?php echo Yii::t('app', 'More reviews') ?></button>
        </form>
    </div>
<?php endif; ?>
<?php
$this->registerJsFile(
    '@web/js/getReviews.js',
    ['depends' => 'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ]
);

$this->registerJsFile(
    '@web/js/getComments.js',
    ['depends' => 'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ]
);
?>


