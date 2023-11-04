<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

use common\models\BasePublications;

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
            [['offset'], 'default', 'value' => 0]
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

}