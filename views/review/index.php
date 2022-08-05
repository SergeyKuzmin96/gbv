<?php use yii\bootstrap4\Html;
use yii\widgets\Pjax;

$review_id = $model['id'] ?>
    <div class="review_id" data-attr="<?= $review_id; ?>">
    </div>
    <br>
    <div id="reviews">
        <div>
            <?= Html::tag('p', Html::tag('strong', '№ ' . $model['id'])) ?>
            <?= Html::tag('p', Html::tag('strong', Yii::t('app', 'Author')) . ' : ' . $model['users']['email']) ?>
            <p><?php echo Html::tag('strong', Yii::t('app', 'Review')) . ' : ' ?><?= Html::encode($model['message']) ?></p>
            <?php $images = $model['reviewsImages']; ?>
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $image): ?>
                    <li><?= Html::img('/images/' . $image['path'], ['width' => 150, 'height' => 120]) ?></li>
                <?php endforeach; ?>
                <hr>
            <?php endif; ?>
        </div>
        <br>
        <?php Pjax::begin([
            'enablePushState' => false,
            'timeout' => 12000,
        ]); ?>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a(Yii::t('app', 'Add Comment'), ['comments/create', 'id' => $review_id], ['class' => 'btn btn-outline-success']) ?>
        <?php endif; ?>
        <?php Pjax::end(); ?>
    </div>
    <br>
    <div id="comments">
        <?php if (count($model['comments']) !== 0): ?>
            <h6><?php echo Html::tag('strong',Yii::t('app', 'Comments')) ?></h6>
            <hr>
            <?php foreach ($model['comments'] as $key => $comment): ?>
                <div>
                    <?= Html::tag('p', Html::tag('strong',Yii::t('app', 'Author')) . ' : ' . $comment['users']['email']) ?>
                    <p><?php echo Html::tag('strong',Yii::t('app', 'Comment')) . ' : ' ?> <?= Html::encode($comment['message']) ?>
                    </p>
                    <?php $images = $comment['commentsImages']; ?>
                    <?php if (!empty($images)): ?>
                        <?php foreach ($images as $image): ?>
                            <ul>
                                <li><?= Html::img('/images/' . $image['path'], ['width' => 150, 'height' => 120]) ?></li>
                            </ul>
                        <?php endforeach; ?>

                    <?php endif; ?>
                    <br>
                    <div>
                    </div>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <i><?php echo Yii::t('app', 'This reviews has not yet been commented on') ?></i>
        <?php endif; ?>
    </div>
<?php if (count($model['comments']) == 5): ?>
    <div>
        <form class="form" id="comment">
            <?= Html::submitButton(Yii::t('app', 'More comments'), ['class' => "btn-outline-info"]); ?>
        </form>
    </div>
<?php else: ?>
    <i><?php echo Yii::t('app', 'No more comments') ?></i>
<?php endif; ?>
<?php

?>