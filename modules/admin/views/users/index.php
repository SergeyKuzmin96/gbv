<?php

use app\models\Users;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\searchModels\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">


    <p>
        <?= Html::a(Yii::t('app', Yii::t('app', 'Add user')), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                'attribute' => 'email',
                'label' => Yii::t('app', 'Email'),
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
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

                'template' => '{view} {update} {delete} {reviews} {comments}',
                'visibleButtons' => [
                    'delete' => function ($model, $key, $index) {
                        return !Yii::$app->authManager->checkAccess($model->id, 'admin');
                    }
                ],

                'buttons' => [
                    'reviews' => function ($url, $model, $key) {
                        return Html::a(Yii::t('app', 'reviews'), $url);
                    },
                    'comments' => function ($url, $model, $key) {
                        return Html::a(Yii::t('app', 'comments'), $url);
                    },
                ],
                'urlCreator' => function ($action, Users $model, $key, $index, $column) {
                    if ($action === 'reviews') {
                        $url = '../../admin/reviews?ReviewsSearch[users]=' . $model->email;
                        return $url;
                    }
                    if ($action === 'comments') {
                        $url = '../../admin/comments?CommentsSearch[users]=' . $model->email;
                        return $url;
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
