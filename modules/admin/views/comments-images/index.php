<?php

use app\components\ImageLoaderComponent;
use app\models\CommentsImages;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\searchModels\CommentsImagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Comment Images');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-image-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'id',
                'options' => ['style' => 'width: 65px; max-width: 65px;'],
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],],
//            'text-align:center',
            [
                'attribute' => 'comment',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'label' => Yii::t('app', 'Comment'),
                'value' => function (CommentsImages $model) {
                    $url = '../../admin/reviews/view/?id=' . $model->comment_id;
                    return Html::a($model->getCommentMessage(), $url);
                },
                'format' => 'raw'
            ],

            [
                'attribute' => 'path',
                'label' => Yii::t('app', 'File name'),
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
            ],

            [
                'attribute' => 'image',
                'label' => Yii::t('app', 'Image'),
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function ($model) {
                    $comp = new ImageLoaderComponent();
                    return $comp->getOneImage($model->path);
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
                'contentOptions' => ['style' => 'text-align: center'],
                'format' => ['date', 'Y-MM-dd HH:mm:ss']
            ],
            [
                'class' => ActionColumn::className(),
                'header' => Yii::t('app', 'Actions'),
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'template' => '{view}{delete}',

                'urlCreator' => function ($action, CommentsImages $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
