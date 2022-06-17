<?php

namespace app\modules\auth\components;

use app\base\BaseComponent;
use app\modules\auth\models\User;
use Yii;
use yii\base\Exception;

class AuthComponent extends BaseComponent
{
    public $model_class;

    /**
     * @throws \Exception
     */
    public function init()
    {
        parent::init();

        if (empty($this->model_class)) {
            throw new \Exception('Need model_class param');
        }
    }

    public function getModel($data = [])
    {
        /** @var User $model */
        $model = new $this->model_class;

        if ($data) {
            $model->load($data);
        }

        return $model;
    }

    /**
     * @param $model User
     * @return bool
     * @throws Exception
     */
    public function createUser(User $model): bool
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
     * @param $model User
     * @return bool
     * @throws Exception
     */
    public function authUser(User $model): bool
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

    private function checkPassword($password, $password_hash): bool
    {
        return Yii::$app->security->validatePassword($password, $password_hash);
    }
}