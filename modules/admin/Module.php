<?php

namespace app\modules\admin;

use Yii;
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
            throw new HttpException(403, Yii::t('app', 'You don\'t have enough rights'));
        }
        return parent::beforeAction($action);
    }
}
