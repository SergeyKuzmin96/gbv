<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "reviews_images".
 *
 * @property int $id
 * @property int $review_id
 * @property string $path
 * @property string $date_add
 * @property string $date_update
 *
 * @property Reviews $review
 */
class ReviewsImages extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'reviews_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['review_id', 'path'], 'required'],
            [['review_id'], 'integer'],
            [['date_add', 'date_update'], 'safe'],
            [['path'], 'string', 'max' => 255],
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
            'review_id' => Yii::t('app', 'Review ID'),
            'path' => Yii::t('app', 'Path'),
            'date_add' => Yii::t('app', 'Date Add'),
            'date_update' => Yii::t('app', 'Date Update'),
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
}
