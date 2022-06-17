<?php

namespace app\controllers;

use app\base\BaseController;
use app\models\Images;
use app\models\Review;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class ReviewController extends BaseController
{
    /**
     * @throws HttpException
     */
    public function actionCreate()
    {

        if (!(\Yii::$app->user->isGuest)) {
            if (!(\Yii::$app->rbac->canCreateReview())) {
                throw new HttpException('403', 'Отзывы могут оставлять только зарегестрированные пользователи!');
            }
            /** @var Review $model
             * @var Images $model_img
             */

            $model = \Yii::$app->review->getModel();
            $model_img = \Yii::$app->images->getModel();

            if (\Yii::$app->request->isPost) {
                $model = \Yii::$app->review->getModel(\Yii::$app->request->post());
                $model_img = \Yii::$app->images->getModel(\Yii::$app->request->post());
                if (\Yii::$app->review->createComment($model, $model_img)) {
                    return $this->redirect(['review/all']);
                }
            }
            return $this->render('create', ['model' => $model, 'model_img' => $model_img]);
        }
        return $this->redirect(['auth/authentication/signin']);
    }


    /**
     * @throws \Exception
     */
    public function actionAll()
    {
        $component = \Yii::$app->review;
        $response = [];
        if (\Yii::$app->request->isAjax) {
            $data = \Yii::$app->request->post();
            $count = ArrayHelper::getValue($data, 'count');
            $reviews = $component->getReviewsByCount($count);

            $response = [
                'status' => true,
                'reviews' => $reviews,
                'message' => 'Успешный вывод отзывов'
            ];
            return Json::encode($response);
        } else {
            $response = [
                'status' => false,
                'reviews' => $response,
                'message' => 'Ошибка получения отзывов'
            ];

            return $this->render('all', ['response' => $response]);
        }
    }

    /**
     * @throws NotFoundHttpException
     */


    public function actionIndex($id): string
    {
        $comp = \Yii::$app->review;
        $review = $comp->getReviewById($id);
        \Yii::$app->session->set('review_id', $id);
        \Yii::$app->session->set('review', $review);
        return $this->render('index', ['model' => $review]);
    }
}