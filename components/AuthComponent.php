<?php

namespace app\components;

use app\models\Users;
use Yii;
use yii\base\BaseObject;
use yii\base\Exception;

class AuthComponent extends BaseObject
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
     * @throws Exception
     */
    public function createUser(Users $model): bool
    {
        $model->setRegisterScenario();

        if (!$model->validate(['email', 'password'])) {
            return false;
        }

        $model->password_hash = $this->generatePasswordHash($model->password);

        if (!$model->save()) {
            return false;
        }
        Yii::$app->rbac->setUserRole($model->id);
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

        $model->auth_key = $this->generateAuthKey();
       if(!($model->updateAttributes(['auth_key']))){
           $error = $model->errors;
       }

        if (!$this->checkPassword($password, $model->password_hash)) {
            $model->addError('password', 'Неправильный пароль');
            return false;
        }

        if (!Yii::$app->user->login($model, 3600)) {
            return false;
        }

        return true;
    }

    /**
     * @param $password
     * @return string
     * @throws Exception
     */
    private function generatePasswordHash($password): string
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @throws Exception
     */
    private function generateAuthKey():string
    {

        return Yii::$app->security->generateRandomString(40);
    }

    public function checkPassword($password, $password_hash): bool
    {
        return Yii::$app->security->validatePassword($password, $password_hash);
    }
}