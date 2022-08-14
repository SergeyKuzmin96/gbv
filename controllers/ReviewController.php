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
        $countAll = $component->getCountReviews();

        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();
            $count = ArrayHelper::getValue($data, 'count');

            $reviews = $component->getReviewsByCountAjax($count);

            for ($i = 0; $i < count($reviews); $i++) {
                $reviews[$i]['canAddComment'] =
                    (Yii::$app->user->id == $reviews[$i]['user_id']) ||
                    Yii::$app->authManager->checkAccess(Yii::$app->user->id, 'admin');
            }
            $data = [
                'status' => true,
                'reviews' => $reviews,
                'message' => Yii::t('app', 'No more reviews'),
                'count' => false
            ];
            if ($countAll > $count) {

                $data['message'] = Yii::t('app', 'More reviews');
                $data['count'] = true;
            }
            return Json::encode($data);

        }
        $reviews = $component->getReviewsByPost();

        return $this->render('all', ['reviews' => $reviews, 'countAll' => $countAll]);
    }

}