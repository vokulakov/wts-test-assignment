<?php

namespace frontend\models;

use common\models\AccessTokens;
use common\models\Publications;
use Yii;
use common\models\Comments;
use yii\db\StaleObjectException;

class CommentsForm extends Comments
{
    public $postId;
    public $limit;
    public $offset;

    public $accessToken;
    public $text;

    public $commentId;

    public $comments;

    public function rules()
    {
        return [
            [['postId', 'commentId'], 'integer'],
            //[['postId'], 'required'],
            [['limit'], 'default', 'value' => Yii::$app->params['limitDefault']],
            [['offset'], 'default', 'value' => Yii::$app->params['offsetDefault']],
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

        $post = Publications::findPostById($this->postId);
        if (empty($post))
        {
            $this->addError('postId','Unknown post id!');
            return false;
        }

        $this->comments = Comments::find()
            ->where(['postId' => $this->postId])
            ->limit($this->limit)
            ->offset($this->offset);

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

        $post = Publications::findPostById($this->postId);
        if (empty($post))
        {
            $this->addError('postId','Unknown post id!');
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

    /**
     * Удалить комментарий с поста
     */
    public function deleteCommentFromPost(): bool
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

        $comment = Comments::findCommentById($this->commentId);
        if (empty($comment))
        {
            $this->addError('commentId', 'Unknown comment id!');
            return false;
        }

        /**
         * Проверяет является ли пользователь автором комментария
         * или же является ли пользователь автором публикации
         */
        $isValidAuthor = $comment->validateAuthorId($user->getId());
        $isValidPostAuthor = Publications::findPostById($comment->getAuthor())->validateAuthorId($user->getId());

        if (!$isValidAuthor || !$isValidPostAuthor)
        {
            $this->addError('authorId', 'Unknown comment author id or post!');
            return false;
        }

        try {
            if (!$comment->delete()) {
                $this->addError('comment', 'Failed to delete comment!');
                $this->addErrors($comment->getErrors());
            }
        } catch (StaleObjectException $e) {
            $this->addError('comment', 'This object is outdated. Failed to delete comment!');
            $this->addErrors($comment->getErrors());
        }

        return true;
    }

    public function serializeResponse()
    {
        $result = [];

        foreach ($this->comments->each() as $comment) {
            $result[] = $comment->serializeToArrayShort();
        }

        return [
            'status' => 'success',
            'data' => [
                'publications' => $result
            ],
            'errors' => $this->errors
        ];
    }

}