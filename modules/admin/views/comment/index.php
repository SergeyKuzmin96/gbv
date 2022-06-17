<?php

use app\models\Comment;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Comment'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'id',
                'options' => ['style' => 'width: 65px; max-width: 65px;'],
                'contentOptions'=>['style'=>'white-space: normal;'],
                ],
            ['attribute' => 'user',
                'value' => function (Comment $model) {
                    $url = '../../admin/user/view/?id=' . $model->user_id;
                    return Html::a($model->getUserEmail(), $url);
                },
                'format' => 'raw'
            ],
            ['attribute' => 'review_id',
                'options' => ['style' => 'width: 65px; max-width: 65px;'],
                'contentOptions'=>['style'=>'white-space: normal;'],
                'value' => function (Comment $model) {
                    $url = '../../admin/review/view/?id=' . $model->review_id;
                    return Html::a($model->review_id, $url);
                },
                'format' => 'raw'],
            'message',
            ['filter' => DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'date_from',
                'attribute2' => 'date_to',
                'options' => ['placeholder' => 'От'],
                'options2' => ['placeholder' => 'До'],
                'type' => DatePicker::TYPE_RANGE,
                'separator' => '-',
                'pluginOptions' => ['format' => 'yyyy-mm-dd',
                    'locale' => ['format' => 'Y-m-d H:i:s'],
                    'autoclose' => true,
                    'todayHighlight' => true,
                    'weekStart' => 1,
                ]
            ]),
                'attribute' => 'date_add',
                'format' => ['date', 'Y-MM-dd HH:mm:ss']
            ],
            [
                'class' => ActionColumn::className(),
                'header' => 'Actions',
                'template' => '{view} {update} {delete} {images}',

                'buttons' => [
                    'images' => function ($url, $model, $key) {
                        return Html::a('images', $url);
                    },
                ],
                'urlCreator' => function ($action, Comment $model, $key, $index, $column) {

                    if ($action === 'images') {
                        $url = '../../admin/comment-image?CommentImageSearch[comment_id]=' . $model->id;
                        return $url;
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
