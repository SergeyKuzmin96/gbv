<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reviews_images".
 *
 * @property int $id
 * @property int $review_id
 * @property string $path
 * @property string $date_add
 *
 * @property Review $review
 */
class ReviewImageBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['review_id', 'path'], 'required'],
            [['review_id'], 'integer'],
            [['date_add'], 'safe'],
            [['path'], 'string', 'max' => 255],
            [['review_id'], 'exist', 'skipOnError' => true, 'targetClass' => Review::className(), 'targetAttribute' => ['review_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'review_id' => Yii::t('app', 'Review ID'),
            'path' => Yii::t('app', 'Path'),
            'date_add' => Yii::t('app', 'Date Add'),
        ];
    }

    /**
     * Gets query for [[Review]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Review::className(), ['id' => 'review_id']);
    }
}
