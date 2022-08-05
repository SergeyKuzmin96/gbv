<?php

namespace app\controllers;

use app\components\CommentsComponent;
use app\components\ReviewsComponent;
use app\models\Reviews;
use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class ReviewController extends Controller
{
    /**
     * @throws InvalidConfigException
     */
    public function actionCreate()
    {

        if (!(Yii::$app->user->isGuest)) {

            /** @var Reviews $model
             */
            $component = new ReviewsComponent();
            $model = $component->getModel();

            if (Yii::$app->request->isPost) {
                $model = $component->getModel(Yii::$app->request->post());

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
        $component = new ReviewsComponent();

        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();
            $count = ArrayHelper::getValue($data, 'count');
            $countAll = $component->getCountReviews();

            if($countAll >= $count || ($count - $countAll > 0 && $count - $countAll < 5)){
                $reviews = $component->getReviewsByCountAjax($count,true);

                $data = [
                    'status' => true,
                    'reviews' => $reviews,
                    'message' => Yii::t('app','Reviews received'),
//                    'counts' => true,
                ];
                return Json::encode($data);
            }else{

                $data = [
                    'status' => true,
                    'reviews' => null,
                    'message' => Yii::t('app','No more reviews'),
//                    'counts' => true,
                ];
                return Json::encode($data);
            }

        }
//        $reviews = $component->getReviewsByCount($count, false);
        $reviews = $component->getReviewsByPost();

        return $this->render('all', ['reviews' => $reviews]);

    }

//    /**
//     * @throws Exception
//     */
//
//    public function actionAll()
//    {
//        $component = new ReviewsComponent();
//        if (Yii::$app->request->isAjax) {
//            $data = Yii::$app->request->post();
//            $count = ArrayHelper::getValue($data, 'count');
//            $reviews = $component->getReviewsByCount($count,true);
////            $reviews = $component->getReviewsByCountAsArray($count);
//
//            if ((count($reviews) % 5 == 0) && (count($reviews) > 0)) {
//                $data = [
//                    'status' => true,
//                    'reviews' => $reviews,
//                    'message' => 'Feedback received',
//                    'counts' => true,
//                ];
//                return Json::encode($data);
//            } else {
//                $data = [
//                    'status' => true,
//                    'reviews' => $reviews,
//                    'message' => 'Feedback received',
//                    'counts' => false,
//                ];
//                return Json::encode($data);
//            }
//
//        }
//        $count = 0;
//        $reviews = $component->getReviewsByCount($count, false);
////        $reviews = $component->getReviewsByCountAsModel($count);
//
//        return $this->render('all', ['reviews' => $reviews]);
//
//    }

}