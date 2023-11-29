<?php

namespace common\models;

class Comments extends BaseComments
{
    public function serializeToArrayShort()
    {
        $dataComment = [
            'commentId' => $this->commentId,
            'authorId' => $this->authorId,
            'commentContent' => $this->commentContent,
            'createdAt' => date('Y-m-d H:i:s', $this->createdAt),
            'updatedAt' => date('Y-m-d H:i:s', $this->updatedAt)
        ];

        return $dataComment;
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function findCommentById($id)
    {
        return static::findOne(['commentId' => $id]);
    }

    public function getAuthor()
    {
        return $this->authorId;
    }

    public function getPost()
    {
        return $this->postId;
    }

    public function validateAuthorId($authorId)
    {
        return $this->getAuthor() === $authorId;
    }
}