<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $user_id
 * @property string $message
 * @property string $date_add
 * @property string $date_update
 *
 * @property Comments[] $reviewsComments
 * @property ReviewsImages[] $reviewsImages
 * @property Users $users
 */
class Reviews extends ActiveRecord
{
    public $images;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'message'], 'required'],
            [['user_id'], 'integer'],
            [['date_add', 'date_update'], 'safe'],
            [['message'], 'string', 'max' => 255],
            ['images', 'file', 'mimeTypes' => 'image/*', 'maxFiles' => 5],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'message' => Yii::t('app', 'Message'),
            'date_add' => Yii::t('app', 'Date Add'),
            'date_update' => Yii::t('app', 'Date Update'),
            'images' => Yii::t('app', 'Images'),
        ];
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

//    public function getCommentsImages()
//    {
//        return $this->hasMany(CommentsImages::className(), ['comment_id' => 'id'])
//            ->via('reviewComments');
//    }

    public function getImagesModel(): ReviewsImages
    {
        $model = new ReviewsImages();
        $model->review_id = $this->id;
        return $model;
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return ActiveQuery
     */
    public function getReviewsComments(): ActiveQuery
    {
        return $this->hasMany(Comments::className(), ['review_id' => 'id']);
    }

    /**
     * Gets query for [[ReviewsImages]].
     *
     * @return ActiveQuery
     */
    public function getReviewsImages(): ActiveQuery
    {
        return $this->hasMany(ReviewsImages::className(), ['review_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function setUserId()
    {

        $this->user_id = Yii::$app->user->getId();
    }

    public function getUserEmail(): string
    {
        return (isset($this->users)) ? $this->users->email : 'не задан';
    }


    public static function getListReviews():array
    {
        return ArrayHelper::map(self::find()->all(),'id','message');
    }
}
