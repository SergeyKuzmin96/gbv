<?php

namespace app\components;

use app\base\BaseComponent;
use app\models\Images;
use app\models\ReviewImage;

class ReviewImageComponent extends BaseComponent
{
    public $model_class = ReviewImage::class;

    public function saveImages($images, $review_id)
    {
        /** @var Images $model
         * @var ReviewImage $image
         */
        foreach ($images as &$path) {
            $image = $this->getModel();
            $image->review_id = $review_id;
            $image->path = $path;
            $image->save();
        }
    }

}