<?php

use app\models\CommentImage;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\CommentImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Comment Images');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-image-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Comment Image'), ['create'], ['class' => 'btn btn-success']) ?>
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
            ['attribute' => 'comment_id',
                'options' => ['style' => 'width: 65px; max-width: 65px;'],
                'contentOptions'=>['style'=>'white-space: normal;'],
                'value' => function (CommentImage $model) {
                    $url = '../../admin/comment/view/?id=' . $model->comment_id;
                    return Html::a($model->comment_id, $url);
                },
                'format' => 'raw'],
            'path',
            ['attribute' => 'image', 'value' => 'oneImage', 'format' => 'raw'],
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
                'urlCreator' => function ($action, CommentImage $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
