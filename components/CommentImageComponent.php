<?php

namespace app\components;

use app\base\BaseComponent;
use app\models\CommentImage;
use app\models\Images;

class CommentImageComponent extends BaseComponent
{
    public $model_class = CommentImage::class;

    public function saveImages($images, $comment_id)
    {
        /** @var Images $model
         * @var CommentImage $image
         */
        foreach ($images as &$path) {
            $image = $this->getModel();
            $image->comment_id = $comment_id;
            $image->path = $path;
            $image->save();
        }
    }
}