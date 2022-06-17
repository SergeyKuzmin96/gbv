<?php

namespace app\models;

use Yii;
use yii\bootstrap4\Html;

/**
 * This is the model class for table "reviews_images".
 *
 * @property int $id
 * @property int $review_id
 * @property string $path
 * @property string $date_add
 *
 * @property Review $review
 */
class ReviewImage extends ReviewImageBase
{

    public function getOneImage($width = null,$height = null): string
    {
        if($width == null){
            $width = 50;
        }
        if($height == null){
            $height = 40;
        }
        return Html::img('/images/' . $this->path, ['width' => $width, 'height' => $height]);
    }
}
