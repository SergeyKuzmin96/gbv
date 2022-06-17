<?php

namespace app\models;

use app\modules\auth\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $user_id
 * @property int $review_id
 * @property string $message
 * @property string $date_add
 *
 * @property CommentImage[] $commentsImages
 * @property Review $review
 * @property User $user
 */
class CommentBase extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'review_id', 'message'], 'required'],
            [['user_id', 'review_id'], 'integer'],
            [['date_add'], 'safe'],
            [['message'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['review_id'], 'exist', 'skipOnError' => true, 'targetClass' => Review::className(), 'targetAttribute' => ['review_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'review_id' => Yii::t('app', 'Review ID'),
            'message' => Yii::t('app', 'Message'),
            'date_add' => Yii::t('app', 'Date Add'),
        ];
    }

    /**
     * Gets query for [[CommentsImages]].
     *
     * @return ActiveQuery
     */
    public function getCommentImages(): ActiveQuery
    {
        return $this->hasMany(CommentImage::className(), ['comment_id' => 'id']);
    }

    /**
     * Gets query for [[Review]].
     *
     * @return ActiveQuery
     */
    public function getReview(): ActiveQuery
    {
        return $this->hasOne(Review::className(), ['id' => 'review_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
