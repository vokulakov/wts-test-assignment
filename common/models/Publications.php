<?php

namespace common\models;

class Publications extends BasePublications
{
    //TODO:: использовать в модели списка постов
    public function serializeToArrayShort()
    {
        /*
        $data = [];
        $data['postId'] = $this->postID;
        return $data;
        */
    }

    //TODO:: использовать в модели деталей постов
    public function serializeToArrayFull()
    {

    }
}