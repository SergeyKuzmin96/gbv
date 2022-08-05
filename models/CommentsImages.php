<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "comments_images".
 *
 * @property int $id
 * @property int $comment_id
 * @property string $path
 * @property string $date_add
 * @property string $date_update
 *
 * @property Comments $comment
 */
class CommentsImages extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'comments_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['comment_id', 'path'], 'required'],
            [['comment_id'], 'integer'],
            [['date_add', 'date_update'], 'safe'],
            [['path'], 'string', 'max' => 255],
            [['comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::className(), 'targetAttribute' => ['comment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'comment_id' => Yii::t('app', 'Comment ID'),
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
     * Gets query for [[Comment]].
     *
     * @return ActiveQuery
     */
    public function getComment(): ActiveQuery
    {
        return $this->hasOne(Comments::className(), ['id' => 'comment_id']);
    }

    public function getCommentMessage(): string
    {
        return $this->comment->message;
    }

}
