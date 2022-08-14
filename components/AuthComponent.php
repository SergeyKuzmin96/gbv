<?php

namespace app\components;

use app\models\Users;
use Yii;
use yii\base\Exception;

class AuthComponent
{
    public function getModel($data = [])
    {
        $model = new Users();
        if ($data) {
            $model->load($data);
        }

        return $model;
    }

    /**
     * @param $model Users
     * @return bool
     * @throws \Exception
     */
    public function createUser(Users $model): bool
    {
        $model->setRegisterScenario();

        if (!$model->validate(['email', 'password'])) {
            return false;
        }

        $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);

        if (!$model->save()) {
            return false;
        }
        $rbac = new RbacComponent();
        $rbac->setUserRole($model->id);
        return true;
    }

    /**
     * @param $model Users
     * @return bool
     * @throws Exception
     */
    public function authUser(Users $model): bool
    {
        $model->setAuthScenario();

        if (!$model->validate(['email', 'password'])) {
            return false;
        }

        $password = $model->password;
        $model = $model::findOne(['email' => $model->email]);
        $model->auth_key = Yii::$app->security->generateRandomString(40);
        if (!($model->updateAttributes(['auth_key']))) {
            $error = $model->errors;
        }

        if (!Yii::$app->security->validatePassword($password, $model->password_hash)) {
            $model->addError('email', Yii::t('app', 'User with such login and password was not found!'));
            return false;
        }

        if (!Yii::$app->user->login($model, 3600)) {
            return false;
        }

        return true;
    }

}