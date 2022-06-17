<?php

namespace app\components;


class ReviewComponent extends CommentsSaveComponent
{

    public function getAllReviews(): array
    {
        $model = $this->getModel();

        return $model::find()->with(['user', 'reviewsImages'])->asArray()->all();
    }


    public function getReviewsByCount(int $count)
    {
        $model = $this->getModel();

        return $model::find()->with(['user', 'reviewsImages'])->limit($count)->asArray()->orderBy('id DESC')->all();
    }


    public function getReviewById($id)
    {
        $model = $this->getModel();

        return $model::find()->andWhere(['id' => $id])->with(['user', 'reviewsImages'])->asArray()->one();

    }


}