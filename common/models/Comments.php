<?php

namespace common\models;

class Comments extends BaseComments
{
    public static function serializeToArrayShort($query)
    {
        $dataComments = [];
        foreach ($query->each() as $comment) {
            $dataComments[] = [
                'commentId' => $comment->postId,
                'authorId' => $comment->authorId,
                'createdAt' => date('Y-m-d H:i:s', $comment->createdAt),
                'updatedAt' => date('Y-m-d H:i:s', $comment->updatedAt)
            ];
        }

        return $dataComments;
    }

    public static function serializeToArrayFull($query)
    {
        $dataComments = [];
        foreach ($query->batch() as $comments)
        {
            $dataPublications = $comments;
        }

        return $dataComments;
    }
}