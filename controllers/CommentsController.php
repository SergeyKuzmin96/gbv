<?php

namespace app\controllers;

use app\base\BaseController;
use app\models\Comment;
use app\models\Images;
use app\models\Review;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\HttpException;

class CommentsController extends BaseController
{
    /**
     * @throws HttpException
     */
    public function actionCreate()
    {
        if (!(Yii::$app->user->isGuest)) {

            $review = Yii::$app->session->get('review');
            if (!(\Yii::$app->rbac->canAddComment($review))) {

                throw new HttpException('403', 'Вы можете комментировать только свои отзывы!');
            }
            /** @var Comment $model
             * @var Images $model_img
             * @var Review $review
             */

            $model = Yii::$app->comment->getModel();
            $model_img = Yii::$app->images->getModel();

            if (Yii::$app->request->isPost) {

                $model = Yii::$app->comment->getModel(Yii::$app->request->post());
                $model->review_id = $review['id'];
                $model_img = Yii::$app->images->getModel(Yii::$app->request->post());
                if (Yii::$app->comment->createComment($model, $model_img)) {

                    return $this->redirect(['review/view']);
                }
            }
            return $this->render('create', ['model' => $model, 'model_img' => $model_img]);
        }
        return $this->redirect(['auth/authentication/signin']);
    }


    /**
     * @throws Exception
     */
    public function actionAll(): string
    {
        if (Yii::$app->request->isAjax) {

            $post = Yii::$app->request->post();
            $count = ArrayHelper::getValue($post, 'count');
            $review = Yii::$app->session->get('review');
            $review_id = $review['id'];
            $comments = Yii::$app->comment->getAllCommentsByReviewAndCount($review_id, $count);

            $data = [
                'status' => true,
                'comments' => $comments,
                'message' => 'Comments received'
            ];
        } else {

            $data = [
                'status' => false,
                'comment' => null,
                'message' => 'An error occurred'
            ];
        }
        return Json::encode($data);
    }
}