<?php
/**
 * @var $model Review
 */

use app\models\Review;
use yii\bootstrap4\Html;
use yii\helpers\Url;

?>

<?= \yii\helpers\Html::a('Посмотреть все отзывы', ['review/all'], ['class' => 'btn btn-outline-info']) ?>
    <br>
    <hr>
    <div id="reviews">
        <div>
            <p>Отзыв №:<strong><?= \yii\helpers\Html::encode($model['id']) ?> </strong></p>
            <p>Автор:<strong><?= \yii\helpers\Html::encode($model['user']['email']) ?> </strong></p>
            <p>Сообщение:<strong><?= \yii\helpers\Html::encode($model['message']) ?> </strong></p>
            <?php $images = $model['reviewsImages']; ?>
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $image): ?>
                    <li><?= \yii\helpers\Html::img('/images/' . $image['path'], ['width' => 150, 'height' => 120]) ?></li>
                <?php endforeach; ?>
                <hr>
            <?php endif; ?>
        </div>
        <br>
        <?php \yii\widgets\Pjax::begin([
            'enablePushState' => false,
            'timeout' => 10000,
        ]); ?>
        <a href="/comments/create" class="btn btn-outline-info">Добавить комментарий</a>
        <?php \yii\widgets\Pjax::end(); ?>
    </div>
    <br>
    <div>
        <form class="form">
            <?= Html::submitButton("Посмотреть 2 последних комментария", ['class' => "btn-outline-danger"]); ?>
        </form>
    </div>

    <div id="comments">

    </div>
<?php
$url = Url::to(['comments/all']);
$script = <<< JS
$(document).ready(function(){
    let count = 0;
    $('.form').submit(function(event) {
        event.preventDefault();
        $('#comments').html('');
        count = count + 2;
        $.ajax({
            url: $url,
            type: 'POST',
            dataType: 'json',
            data: count,
            
            success (data){
                if (data.status){
                    let layout = '';
                    for (let i = 0; i < data.comment.length; i++){
                        let images = '';
                        for (let j = 0; j< data.comment[i].imgforcomments.length; j++){
                            images += `<li><img src="/images/`+data.comment[i].imgforcomments[j].name+`" width="150" height="120"></li>`
                        }
                    layout += `
<div>
    <p>Автор: `+data.comment[i].user.name+`</p>
    <p>Сообщени:<strong>`+data.comment[i].message+`</strong></p>
    <ul>                    
    `+images+`
    </ul>    
    <hr>
</div>
                    `;}
                    $('#comments').append(layout);
                    console.log(data);
                }
            }
            })
        });
    });
JS;
$this->registerJs($script);
?>