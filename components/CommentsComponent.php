<?php

namespace app\components;


use app\models\Comments;
use app\models\CommentsImages;
use Exception;
use Yii;

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

    /**
     * @throws Exception
     */
    public function deleteComment($id): bool
    {
        $image_comp = new ImageLoaderComponent();
        $model = Comments::find()->andWhere(['id' => $id])->one();

        $trans = Comments::getDb()->beginTransaction();
        try {
            $images = CommentsImages::find()->select('path')->andWhere(['comment_id' => $id])->asArray()->all();
            $image_comp->deleteImagesFromServer($images);
            CommentsImages::deleteAll(['comment_id' => $id]);

            $model->delete();
            $trans->commit();
            return true;
        } catch (Exception $e) {

            $trans->rollBack();
            throw $e;
        }
    }

}