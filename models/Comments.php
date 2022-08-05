<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $user_id
 * @property int $review_id
 * @property string $message
 * @property string $date_add
 * @property string $date_update
 *
 * @property CommentsImages[] $commentsImages
 * @property Reviews $review
 * @property Users $users
 */
class Comments extends ActiveRecord
{
    public $images;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'comments';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_update', 'date_add'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
                'value' => new Expression('NOW()')
            ],
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'review_id', 'message'], 'required'],
            [['user_id', 'review_id'], 'integer'],
            [['date_add', 'date_update'], 'safe'],
            [['message'], 'string', 'max' => 255],
            ['images', 'file', 'mimeTypes' => 'image/*', 'maxFiles' => 5],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['review_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reviews::className(), 'targetAttribute' => ['review_id' => 'id']],
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
            'review_id' => Yii::t('app', 'Review'),
            'message' => Yii::t('app', 'Message'),
            'date_add' => Yii::t('app', 'Date Add'),
            'date_update' => Yii::t('app', 'Date Update'),
            'images' => Yii::t('app', 'Images'),

        ];
    }

    public function getImagesModel(): CommentsImages
    {
        $model = new CommentsImages();
        $model->comment_id = $this->id;
        return $model;
    }

    /**
     * Gets query for [[CommentsImages]].
     *
     * @return ActiveQuery
     */
    public function getCommentsImages(): ActiveQuery
    {
        return $this->hasMany(CommentsImages::className(), ['comment_id' => 'id']);
    }

    /**
     * Gets query for [[Review]].
     *
     * @return ActiveQuery
     */
    public function getReview(): ActiveQuery
    {
        return $this->hasOne(Reviews::className(), ['id' => 'review_id']);
    }

    public function getReviewMessage(): string
    {
        return $this->review->message;
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getUserEmail(): string
    {
        return (isset($this->users)) ? $this->users->email : 'не задан';
    }
}
