<?php

namespace app\modules\auth\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

class AuthenticationController extends Controller
{

    /**
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        if (!(\Yii::$app->user->isGuest)) {
            $this->goHome();
        }
        return parent::beforeAction($action);
    }

    public function actionSignup()
    {
        $model = \Yii::$app->auth->getModel();
        if (\Yii::$app->request->isPost) {
            $model = \Yii::$app->auth->getModel(\Yii::$app->request->post());

            if (\Yii::$app->auth->createUser($model)) {
                return $this->redirect(Url::to(['authentication/signin']));
            }
        }
        return $this->render('signup', ['model' => $model]);
    }


    public function actionSignin()
    {
        $model = \Yii::$app->auth->getModel();

        if (\Yii::$app->request->isPost) {
            $model = \Yii::$app->auth->getModel(\Yii::$app->request->post());

            if (\Yii::$app->auth->authUser($model)) {
                return $this->redirect('../../review/all');
            }
        }

        return $this->render('signin', [
            'model' => $model
        ]);
    }

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}