<?php


/* @var $this \yii\web\View */

/* @var $data array */

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<?php Pjax::begin([
    'enablePushState' => false,
    'timeout' => 7000,
]); ?>
    <a href="create" class="btn btn-xs btn-primary">Оставить отзыв</a>
<?php Pjax::end(); ?>
    <br>
    <hr>
    <div class="container">
        <form class="form">
            <h3>Отзывы пользователей</h3>
            <?= Html::submitButton("Получить", ['class' => "btn-info"]); ?>
        </form>
    </div>
    <br>
    <hr>
<?php Pjax::begin([
    'enablePushState' => false,
    'timeout' => 10000,
]); ?>

<? //=print_r($data); ?>
    <div id="reviews">

    </div>
<?php Pjax::end(); ?>


<?php
$url = Url::to(['review/all']);
$script = <<< JS
$(document).ready(function(){
    
    let count = 0;
    $('.form').submit(function(event) {
        event.preventDefault();
        $('#reviews').html('');
        count = count + 2;
        $.ajax({
            url: '$url',
            type: 'POST',
            dataType: 'json',
            data:{
                count : count
            },
            success (data){
                if (data.status){
                    let layout = '';
                    for (let i = 0; i < data.reviews.length; i++){
                        let images = '';
                        for (let j = 0; j< data.reviews[i].reviewsImages.length; j++){
                            images += `<li><img src="/images/`+data.reviews[i].reviewsImages[j].path+`" width="150" height="120"></li>`
                        }
                    layout += `
<div>
    <p>Номер отзыва: `+data.reviews[i].id+`</p>
    <p>Автор: `+data.reviews[i].user.email+`</p>
    <p>Сообщени:<strong>`+data.reviews[i].message+`</strong></p>
    <ul>                    
    `+images+`
    </ul>
    <br>
    <div>
    <a href="/review/?id=`+data.reviews[i].id+`" class="btn btn-success">Комментарии</a>
    </div>
    <hr>
</div>
                    `;}
                    $('#reviews').append(layout);
                    console.log(data);                
            }
            }
            })
        });
    });
JS;
$this->registerJs($script);
?>