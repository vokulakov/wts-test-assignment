<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

use common\models\Publications;
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
            [['limit'], 'default', 'value' => Yii::$app->params['limitDefault']],
            [['offset'], 'default', 'value' => Yii::$app->params['offsetDefault']],
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

        $this->publications = Publications::find()
            ->limit($this->limit)
            ->offset($this->offset);

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

        $this->publications = Publications::find()
            ->where(['authorID' => $user->id])
            ->limit($this->limit)
            ->offset($this->offset);

        return true;
    }

    /**
     * Сериализация ответа (полный)
     */
    public function serializeAllResponse()
    {
        $result = [];

        foreach ($this->publications->batch() as $publication) {
            $result[] = $publication;
        }

        return [
            'status' => 'success',
            'data' => [
                'publications' => $result
            ],
            'errors' => $this->errors
        ];
    }

    /**
     * Сериализация ответа (сокращенный)
     */
    public function serializeShortResponse()
    {
        $result = [];

        foreach ($this->publications->each() as $publication) {
            $result[] = $publication->serializeToArrayShort();
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