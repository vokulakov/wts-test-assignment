<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Comments;
class CommentsForm extends Model
{
    public $postId;
    public $limit;
    public $offset;

    public $comments;

    public function rules()
    {
        return [
            [['postId'], 'integer'],
            [['postId'], 'required'],
            [['limit'], 'default', 'value' => 15],
            [['offset'], 'default', 'value' => 0]
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
}