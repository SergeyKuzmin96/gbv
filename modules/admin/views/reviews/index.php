<?php

use app\models\Reviews;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\searchModels\ReviewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reviews');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-index">

    <p>
        <?= Html::a(Yii::t('app', Yii::t('app', 'Add review')), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'options' => ['style' => 'width: 65px; max-width: 65px;'],
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
            ],

            [
                'attribute' => 'users',
                'label' => Yii::t('app', 'Author'),
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function (Reviews $model) {
                    $url = '../../admin/users/view/?id=' . $model->user_id;
                    return Html::a($model->getUserEmail(), $url);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'message',
                'label' => Yii::t('app','Review'),
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' =>['style' => 'text-align: center'],
            ],

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
                'label' => Yii::t('app', 'Date add'),
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'format' => ['date', 'Y-MM-dd HH:mm:ss']
            ],

            [
                'class' => ActionColumn::className(),
                'header' => Yii::t('app', 'Actions'),
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],

                'template' => '{view} {update} {delete} {comments} {images}',
                'buttons' => [
                    'comments' => function ($url, $model, $key) {
                        return Html::a(Yii::t('app','comments'), $url);
                    },
                    'images' => function ($url, $model, $key) {
                        return Html::a(Yii::t('app', 'images'), $url);
                    },
                ],
                'urlCreator' => function ($action, Reviews $model, $key, $index, $column) {
                    if ($action === 'comments') {
                        $url = '../../admin/comments?CommentsSearch[review]=' . $model->message;
                        return $url;
                    }
                    if ($action === 'images') {
                        $url = '../../admin/reviews-images?ReviewsImagesSearch[review]=' . $model->message;
                        return $url;
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],

        ],
    ]); ?>
    <?php Pjax::end(); ?>


</div>
