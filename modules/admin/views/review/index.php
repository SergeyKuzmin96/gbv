<?php

use app\models\Review;
use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;
use kartik\datecontrol\Module;
use kartik\field\FieldRange;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reviews');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Review'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id',
                'options' => ['style' => 'width: 65px; max-width: 65px;'],
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
//            ['attribute' => 'user', 'value' => 'userEmail'],
            ['attribute' => 'user',
                'value' => function (Review $model) {
                    $url = '../../admin/user/view/?id=' . $model->user_id;
                    return Html::a($model->getUserEmail(), $url);
                },
                'format' => 'raw'
            ],

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

            ['class' => ActionColumn::className(),
                'header' => 'Actions',
                'template' => '{view} {update} {delete} {comments} {images}',

                'buttons' => [
                    'comments' => function ($url, $model, $key) {
                        return Html::a('comments', $url);
                    },
                    'images' => function ($url, $model, $key) {
                        return Html::a('images', $url);
                    },
                ],
                'urlCreator' => function ($action, Review $model, $key, $index, $column) {
                    if ($action === 'comments') {
                        $url = '../../admin/comment?CommentSearch[review_id]=' . $model->id;
                        return $url;
                    }
                    if ($action === 'images') {
                        $url = '../../admin/review-image?ReviewImageSearch[review_id]=' . $model->id;
                        return $url;
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],

        ],
    ]); ?>
    <?php Pjax::end(); ?>


</div>
