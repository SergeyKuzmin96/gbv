<?php

namespace app\modules\admin\controllers;

use app\modules\auth\models\User;
use Yii;

class SiteController extends SearchController
{
    public function actionIndex()
    {
        return $this->render('index');

    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new User();
        $comp = Yii::$app->auth;
        if ($model->load(Yii::$app->request->post()) && $comp->authUser($model)) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
}