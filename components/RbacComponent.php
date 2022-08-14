<?php

namespace app\components;

use Exception;
use Yii;

class RbacComponent
{
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
     * @throws Exception
     */
    public function setUserRole($id)
    {
        $auth_manager = Yii::$app->authManager;
        $user = $auth_manager->getRole('users');
        if ($user != null) {
            $auth_manager->assign($user, $id);
        }
    }
}


