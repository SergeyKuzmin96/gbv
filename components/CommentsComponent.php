<?php

namespace app\components;


class CommentsComponent extends CommentsSaveComponent
{

    public function getAllCommentsByReviewAndCount($review_id, $count): array
    {
        $model = $this->getModel();
        return $model::find()->where(['review_id' => $review_id])->with(['user', 'commentImages'])->asArray()->orderBy('id DESC')->all();

    }

}