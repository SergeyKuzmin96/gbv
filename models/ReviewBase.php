<?php

namespace app\models;

use app\modules\auth\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $user_id
 * @property string $message
 * @property string $date_add
 *
 * @property Comment[] $reviewsComments
 * @property ReviewImage[] $reviewsImages
 * @property User $user
 */
class ReviewBase extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'message'], 'required'],
            [['user_id'], 'integer'],
            [['date_add'], 'safe'],
            [['message'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'message' => Yii::t('app', 'Message'),
            'date_add' => Yii::t('app', 'Date Add'),
        ];
    }

    /**
     * Gets query for [[ReviewsImages]].
     *
     * @return ActiveQuery
     */
    public function getReviewsImages(): ActiveQuery
    {
        return $this->hasMany(ReviewImage::className(), ['review_id' => 'id']);
    }

    /**
     * Gets query for [[ReviewsComments]].
     *
     * @return ActiveQuery
     */
    public function getReviewsComments(): ActiveQuery
    {
        return $this->hasMany(Comment::className(), ['review_id' => 'id']);
    }



    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
