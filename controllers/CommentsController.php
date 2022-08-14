<?php

namespace app\controllers;

use app\components\CommentsComponent;
use app\components\RbacComponent;
use app\models\Comments;
use app\models\Reviews;
use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;

class CommentsController extends Controller
{
    /**
     * @throws HttpException
     * @throws InvalidConfigException
     */
    public function actionCreate($id)
    {
        if (!(Yii::$app->user->isGuest)) {

            $review = Reviews::find()->andFilterWhere(['id' => $id])->asArray()->one();
            $rbac = new RbacComponent();
            if (!($rbac->canAddComment($review))) {

                throw new HttpException('403', Yii::t('app', 'You do not have enough rights to leave comments') . '!');
            }
            /** @var Comments $model
             * @var Reviews $review
             */

            $component = new CommentsComponent();
            $model = $component->getModel();

            if (Yii::$app->request->isPost) {

                $model = $component->getModel(Yii::$app->request->post());
                $model->review_id = $id;
                if ($component->createComment($model)) {
                    return $this->redirect(Url::to(['/review/all']));

                }
            }
            return $this->render('create', ['model' => $model]);
        }
        return $this->redirect(['authentication/signin']);
    }

    /**
     * @throws Exception
     */
    public function actionAll()
    {
        if (Yii::$app->request->isAjax) {

            $post = Yii::$app->request->post();
            $count = ArrayHelper::getValue($post, 'count');
            $review_id = ArrayHelper::getValue($post, 'review_id');

            $component = new CommentsComponent();
            $countAll = $component->getCountCommentsByReview($review_id);

            if (($count > 5 && $countAll == 0) || (($count - $countAll) >= 5 && $countAll > 0)) {
                $data = [
                    'status' => false,
                    'comments' => null,
                    'message' => Yii::t('app', 'Comments'),
                    'counts' => true,
                ];
            } else {

                if ($countAll == 0) {

                    $data = [
                        'status' => false,
                        'comments' => null,
                        'message' => Yii::t('app', 'This reviews has not yet been commented on'),
                        'counts' => false,
                    ];

                } else {

                    $comments = $component->getAllCommentsByReviewAndCount($review_id, $count);

                    if ((($countAll % 5 === 0) && $countAll === $count) || (($count - $countAll < 5) && ($count - $countAll > 0))) {

                        $data = [
                            'status' => true,
                            'comments' => $comments,
                            'message' => Yii::t('app', 'No more comments'),
                            'counts' => false,
                        ];

                    } else {
                        $data = [
                            'status' => true,
                            'comments' => $comments,
                            'message' => Yii::t('app', 'More comments'),
                            'counts' => true,
                        ];
                    }
                }
            }
            return Json::encode($data);
        }
    }

}
