<?php

namespace app\models;

use Yii;
use yii\bootstrap4\Html;

/**
 * This is the model class for table "comments_images".
 *
 * @property int $id
 * @property int $comment_id
 * @property string $path
 * @property string $date_add
 *
 * @property Comment $comment
 */
class CommentImage extends CommentImageBase
{
    public function getOneImage($width = null, $height = null): string
    {
        if ($width == null) {
            $width = 50;
        }
        if ($height == null) {
            $height = 40;
        }

        return Html::img('/images/' . $this->path, ['width' => $width, 'height' => $height]);
    }
}
