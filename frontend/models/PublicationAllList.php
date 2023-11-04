<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

use common\models\BasePublications;

class PublicationAllList extends Model
{
    public $limit;
    public $offset;

    public $publications;

    public function rules()
    {
        return [
            [['limit'], 'default', 'value' => 15],
            [['offset'], 'default', 'value' => 0]
        ];
    }

    public function AllList()
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