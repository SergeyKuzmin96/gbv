<?php

namespace app\modules\admin;

use yii\web\HttpException;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    public function beforeAction($action): bool
    {
        if (!\Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin')) {
            throw new HttpException(403, 'У вас недостаточно прав!');
        }
        return parent::beforeAction($action);
    }
}
