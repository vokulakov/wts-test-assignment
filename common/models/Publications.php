<?php

namespace common\models;

class Publications extends BasePublications
{

    public function serializeToArrayShort()
    {
        $dataPublication = [
            'postID' => $this->postID,
            'tittle' => $this->tittle,
            'createdAt' => date('Y-m-d H:i:s', $this->createdAt)
        ];

        return $dataPublication;
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function findPostById($id)
    {
        return static::findOne(['postID' => $id]);
    }

    public function getAuthor()
    {
        return $this->authorID;
    }

    public function validateAuthorId($authorId)
    {
        return $this->getAuthor() === $authorId;
    }

    public function getComments()
    {
        return $this->hasMany(Comments::class, ['postId' => 'postID']);
    }
}