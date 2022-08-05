<?php

namespace app\rules;

use yii\helpers\ArrayHelper;
use yii\rbac\Rule;

class CommentOwnerReviewRule extends Rule
{
    public $name = 'commentOwnerReviewRule';

    /**
     * @throws \Exception
     */
    public function execute($user, $item, $params): bool
    {
        $review = ArrayHelper::getValue($params, 'reviews');

        return $review['user_id'] == $user;
    }
}