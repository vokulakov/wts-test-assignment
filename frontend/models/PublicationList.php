<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

use common\models\BasePublications;
use common\models\AccessTokens;

class PublicationList extends Model
{
    public $limit;
    public $offset;
    public $accessToken;

    public $publications;

    public function rules()
    {
        return [
            [['limit'], 'default', 'value' => 15],
            [['offset'], 'default', 'value' => 0],
            [['accessToken'], 'string']
        ];
    }

    /*
     * Получить все публикации
     */
    public function getAllPublication(): bool
    {
        if (!$this->validate())
        {
            return false;
        }

        $this->publications = BasePublications::find()
            ->limit($this->limit)
            ->offset($this->offset)
            ->all();

        return true;
    }

    /*
     * Получить список публикаций пользователя
     */
    public function getUserPublications(): bool
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

        $this->publications = BasePublications::find()
            ->where(['authorID' => $user->id])
            ->limit($this->limit)
            ->offset($this->offset)
            ->all();

        return true;
    }

}