<?php

namespace app\models;

use app\modules\auth\models\User;
use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $user_id
 * @property int $review_id
 * @property string $message
 * @property string $date_add
 *
 * @property CommentImage[] $commentsImages
 * @property Review $review
 * @property User $user
 */
class Comment extends CommentBase
{
    public function getUserEmail(): string
    {
        return (isset($this->user)) ? $this->user->email : 'не задан';
    }
}
