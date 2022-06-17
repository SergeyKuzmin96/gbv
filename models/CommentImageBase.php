<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments_images".
 *
 * @property int $id
 * @property int $comment_id
 * @property string $path
 * @property string $date_add
 *
 * @property Comment $comment
 */
class CommentImageBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_id', 'path'], 'required'],
            [['comment_id'], 'integer'],
            [['date_add'], 'safe'],
            [['path'], 'string', 'max' => 255],
            [['comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::className(), 'targetAttribute' => ['comment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'comment_id' => Yii::t('app', 'Comment ID'),
            'path' => Yii::t('app', 'Path'),
            'date_add' => Yii::t('app', 'Date Add'),
        ];
    }

    /**
     * Gets query for [[Comment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comment::className(), ['id' => 'comment_id']);
    }
}
