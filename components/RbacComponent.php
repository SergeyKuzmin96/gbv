<?php

namespace app\components;

use app\rules\CommentOwnerReviewRule;
use Yii;
use yii\base\BaseObject;
use yii\rbac\ManagerInterface;

class RbacComponent extends BaseObject
{
    /**
     * @return ManagerInterface
     */
    private function getAuthManager(): ManagerInterface
    {
        return \Yii::$app->authManager;
    }

    /**
     * @throws \Exception
     */
    public function generateRbac()
    {
        $authManager = $this->getAuthManager();

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

    public function canCreateReview(): bool
    {
        return Yii::$app->user->can('create_review');
    }

    public function canAddComment($review): bool
    {
        if (Yii::$app->user->can('adminAccess')) {
            return true;
        }
        if (Yii::$app->user->can('add_comment', ['reviews' => $review])) {
            return true;
        }
        return false;
    }

    /**
     * @throws \Exception
     */
    public function setUserRole($id)
    {
        $auth_manager = $this->getAuthManager();
        $user = $auth_manager->getRole('users');
        if ($user != null) {
            $auth_manager->assign($user, $id);
        }
    }
}


