<?php

namespace common\models;

class Publications extends BasePublications
{
    public static function serializeToArrayShort($query)
    {
        $dataPublications = [];
        foreach ($query->each() as $publication) {
            $dataPublications[] = [
                'postID' => $publication->postID,
                'tittle' => $publication->tittle,
                'createdAt' => date('Y-m-d H:i:s', $publication->createdAt)
            ];
        }

        return $dataPublications;
    }

    public static function serializeToArrayFull($query)
    {
        $dataPublications = [];

        foreach ($query->batch() as $publications)
        {
            $dataPublications = $publications;
        }

        return $dataPublications;
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