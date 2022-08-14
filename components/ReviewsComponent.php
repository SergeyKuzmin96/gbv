<?php

namespace app\components;


use app\models\Comments;
use app\models\CommentsImages;
use app\models\Reviews;
use app\models\ReviewsImages;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;

class ReviewsComponent extends CommentsSaveComponent
{
    public $model_class = Reviews::class;

    public function getReviewsByCountAjax($count)
    {
        $model = $this->getModel();
        return $model::find()->with(['users', 'reviewsImages'])
            ->limit(5)->Offset($count - 5)->orderBy('id DESC')->asArray()->all();
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

    /**
     * @throws StaleObjectException
     * @throws Exception
     * @throws \Exception
     */
    public function deleteReview($id): bool
    {
        $image_comp = new ImageLoaderComponent();
        $model = Reviews::find()->andWhere(['id' => $id])->with(['reviewsComments'])->one();

        $trans = Reviews::getDb()->beginTransaction();
        try {

            $comments = $model->reviewsComments;
            foreach ($comments as $comment) {
                $images = CommentsImages::find()->select('path')->andWhere(['comment_id' => $comment->id])->asArray()->all();
                $image_comp->deleteImagesFromServer($images);
                CommentsImages::deleteAll(['comment_id' => $comment->id]);
            }
            Comments::deleteAll(['review_id' => $id]);

            $review_images = ReviewsImages::find()->select('path')->andWhere(['review_id' => $id])->asArray()->all();
            $image_comp->deleteImagesFromServer($review_images);
            ReviewsImages::deleteAll(['review_id' => $id]);

            $model->delete();
            $trans->commit();
            return true;
        } catch (Exception $e) {

            $trans->rollBack();
            throw $e;
        }
    }

}