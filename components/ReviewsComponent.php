<?php

namespace app\components;


use app\models\Reviews;

class ReviewsComponent extends CommentsSaveComponent
{
    public $model_class = Reviews::class;

    public function getAllReviews(): array
    {
        $model = $this->getModel();

        return $model::find()->with(['users', 'reviewsImages'])->asArray()->all();
    }

    public function getReviewsByCountAjax($count, bool $isAjax)
    {
        $model = $this->getModel();
        $reviews = $model::find()->with(['users', 'reviewsImages'])
            ->limit(5)->Offset($count - 5)->orderBy('id DESC');
        if ($isAjax) {
            return $reviews->asArray()->all();
        }
        return $reviews->all();
    }

    public function getCountReviews(): int
    {
        $model = $this->getModel();
        return $model::find()->count();
    }
    public function getReviewsByPost()
    {
        $model = $this->getModel();
        return $model::find()->with(['users', 'reviewsImages'])
            ->limit(5)->orderBy('id DESC')->all();
    }

//    public function getReviewsByCountAsArray($count)
//    {
//        $model = $this->getModel();
//        return $model::find()->with(['users', 'reviewsImages'])
//            ->limit(5 + $count)->Offset($count)->orderBy('id DESC')->asArray()->all();
//    }


    public function getReviewById($id)
    {
        $model = $this->getModel();

        return $model::find()->andWhere(['id' => $id])->with(['user', 'reviewsImages'])->asArray()->one();

    }


}