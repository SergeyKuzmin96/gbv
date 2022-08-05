<?php

namespace app\components;


use app\models\Comments;

class CommentsComponent extends CommentsSaveComponent
{
    public $model_class = Comments::class;


    public function getAllCommentsByReviewAndCount($review_id, $count): array
    {
        $model = $this->getModel();
        return $model::find()->where(['review_id' => $review_id])->with(['users', 'commentsImages'])->offset($count - 5)->limit($count)->asArray()->all();

    }

    public function getCountCommentsByReview($review_id)
    {
        $model = $this->getModel();
        return $model::find()->where(['review_id' => $review_id])->count();
    }
}