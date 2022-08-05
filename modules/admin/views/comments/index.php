<?php

use app\models\Comments;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\searchModels\CommentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <p>
        <?= Html::a(Yii::t('app', Yii::t('app', 'Add Comment')), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'id',
                'options' => ['style' => 'width: 65px; max-width: 65px;'],
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
            ],

            ['attribute' => 'user',
                'label' => Yii::t('app', 'Author'),
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function (Comments $model) {
                    $url = '../../admin/users/view/?id=' . $model->user_id;
                    return Html::a($model->getUserEmail(), $url);
                },
                'format' => 'raw'
            ],

            [
                'attribute' => 'message',
                'label' => Yii::t('app', 'Comment'),
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
            ],

            [
                'attribute' => 'review',
                'label' => Yii::t('app', 'Review'),
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function (Comments $model) {
                    $url = '../../admin/reviews/view/?id=' . $model->review_id;
                    return Html::a($model->getReviewMessage(), $url);
                },
                'format' => 'raw'
            ],

            [
                'filter' => DatePicker::widget([
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
                'label' => Yii::t('app', 'Date add'),
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' =>['style' => 'text-align: center'],
                'format' => ['date', 'Y-MM-dd HH:mm:ss']
            ],

            [
                'class' => ActionColumn::className(),
                'header' => Yii::t('app', 'Actions'),
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' =>['style' => 'text-align: center'],
                'template' => '{view} {update} {delete} {images}',

                'buttons' => [
                    'images' => function ($url, $model, $key) {
                        return Html::a(Yii::t('app','images'), $url);
                    },
                ],
                'urlCreator' => function ($action, Comments $model, $key, $index, $column) {

                    if ($action === 'images') {
                        $url = '../../admin/comments-images?CommentsImagesSearch[comment]=' . $model->message;
                        return $url;
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
