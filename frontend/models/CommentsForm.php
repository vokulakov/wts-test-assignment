<?php

namespace frontend\models;

use common\models\AccessTokens;
use Yii;
use yii\base\Model;
use common\models\Comments;
class CommentsForm extends Model
{
    public $postId;
    public $limit;
    public $offset;

    public $accessToken;
    public $text;

    public $comments;

    public function rules()
    {
        return [
            [['postId'], 'integer'],
            [['postId'], 'required'],
            [['limit'], 'default', 'value' => 15],
            [['offset'], 'default', 'value' => 0],
            [['text', 'accessToken'], 'string']
        ];
    }

    /**
     * Получить все комментарии к посту по идентификатору поста
     * @return bool
     */
    public function getCommentsFromPostId(): bool
    {
        if (!$this->validate())
        {
            return false;
        }

        $queryResult = Comments::find()
            ->where(['postId' => $this->postId])
            ->limit($this->limit)
            ->offset($this->offset);

        $this->comments = Comments::serializeToArrayFull($queryResult);

        return true;
    }

    /**
     * Добавить комментарий к посту
     */
    public function addCommentToPost(): bool
    {
        if (!$this->validate())
        {
            return false;
        }

        $user = AccessTokens::getUserFromToken($this->accessToken);
        if (empty($user))
        {
            $this->addError('accessToken','Invalid access token!');
            return false;
        }

        $comment = new Comments();
        $comment->commentContent = $this->text;
        $comment->postId = $this->postId;
        $comment->authorId = $user->getId();
        $comment->createdAt = time();
        $comment->updatedAt = time();

        if (!$comment->save()) {
            $this->addError('comment', 'Failed to publish comment!');
            $this->addErrors($comment->getErrors());
            return false;
        }

        return true;
    }

}