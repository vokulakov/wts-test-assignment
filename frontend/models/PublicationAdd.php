<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

use common\models\Publications;
use common\models\AccessTokens;

class PublicationAdd extends Model
{
    public $text;
    public $tittle;
    public $accessToken;

    public function rules()
    {
        return [
            [['tittle', 'text', 'accessToken'], 'required'],
            [['tittle', 'text'], 'string']
        ];
    }

    /*
     * Публикация поста
     */
    public function add()
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

        $publication = new Publications();
        $publication->tittle = $this->tittle;
        $publication->text = $this->text;
        $publication->authorID = $user->getId();
        $publication->createdAt = time();

        if (!$publication->save()) {
            $this->addError('publication', 'Failed to publish post!');
            $this->addErrors($publication->getErrors());
            return false;
        }

        return true;
    }

}