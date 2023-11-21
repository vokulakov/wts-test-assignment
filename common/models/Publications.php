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
}