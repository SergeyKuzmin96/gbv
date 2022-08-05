<?php

namespace app\controllers;

use app\components\AuthComponent;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
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

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function actionSignup()
    {
        $component = new AuthComponent();
        $model = $component->getModel();

        if (\Yii::$app->request->isPost) {
            $model = $component->getModel(\Yii::$app->request->post());

            if ($component->createUser($model)) {
                return $this->redirect(Url::to(['authentication/signin']));
            }
        }
        return $this->render('signup', ['model' => $model]);
    }


    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function actionSignin()
    {
        $component = new AuthComponent();
        $model = $component->getModel();

        if (\Yii::$app->request->isPost) {
            $model = $component->getModel(\Yii::$app->request->post());

            if ($component->authUser($model)) {
                return $this->redirect(['review/all']);
            }
        }

        return $this->render('signin', ['model' => $model]);
    }

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}