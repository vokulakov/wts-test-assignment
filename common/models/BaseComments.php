<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int $commentId
 * @property string $commentContent
 * @property int $createdAt
 * @property int $updatedAt
 * @property int $postId
 * @property int $authorId
 *
 * @property User $author
 * @property Publications $post
 */
class BaseComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['commentContent', 'createdAt', 'updatedAt', 'postId', 'authorId'], 'required'],
            [['commentContent'], 'string'],
            [['createdAt', 'updatedAt', 'postId', 'authorId'], 'integer'],
            [['authorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['authorId' => 'id']],
            [['postId'], 'exist', 'skipOnError' => true, 'targetClass' => Publications::class, 'targetAttribute' => ['postId' => 'postID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'commentId' => 'Comment ID',
            'commentContent' => 'Comment Content',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'postId' => 'Post ID',
            'authorId' => 'Author ID',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'authorId']);
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Publications::class, ['postID' => 'postId']);
    }
}
