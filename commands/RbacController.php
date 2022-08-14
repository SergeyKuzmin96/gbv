<?php

namespace app\commands;

use app\rules\CommentOwnerReviewRule;
use Exception;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionGen()
    {
        $authManager = Yii::$app->authManager;

        $authManager->removeAll();

        $admin = $authManager->createRole('admin');
        $user = $authManager->createRole('users');

        $authManager->add($admin);
        $authManager->add($user);

        $create_review = $authManager->createPermission('create_review');
        $create_review->description = 'Создание Отзыва';
        $authManager->add($create_review);

        $add_comment = $authManager->createPermission('add_comment');
        $add_comment->description = 'Добавление комментария';

        $commentOwnerReviewRule = new CommentOwnerReviewRule();
        $authManager->add($commentOwnerReviewRule);
        $add_comment->ruleName = $commentOwnerReviewRule->name;
        $authManager->add($add_comment);

        $adminAccess = $authManager->createPermission('adminAccess');
        $adminAccess->description = 'Права администратора';
        $authManager->add($adminAccess);

        $authManager->addChild($user, $create_review);
        $authManager->addChild($user, $add_comment);
        $authManager->addChild($admin, $user);
        $authManager->addChild($admin, $adminAccess);;

        $authManager->assign($admin, 1);
    }
}