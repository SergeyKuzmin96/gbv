<?php

namespace app\commands;

use yii\console\Controller;

class RbacController extends Controller
{
    public function actionGen(){
        \Yii::$app->rbac->generateRbac();
    }
}