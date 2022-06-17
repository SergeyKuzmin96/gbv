<?php

namespace app\models;

use app\modules\auth\models\User;
use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $user_id
 * @property string $message
 * @property string $date_add
 *
 * @property ReviewImage[] $reviewsImages
 * @property User $user
 */
class Review extends ReviewBase
{

    public function setUserId()
    {

        $this->user_id = Yii::$app->user->getId();
    }

    public function getUserEmail(): string
    {
        return (isset($this->user)) ? $this->user->email : 'не задан';
    }
}
