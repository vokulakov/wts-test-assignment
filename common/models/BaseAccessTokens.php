<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "accessTokens".
 *
 * @property int $tokenID
 * @property int $userID
 * @property string $accessToken
 *
 * @property User $user
 */
class BaseAccessTokens extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accessTokens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userID', 'accessToken'], 'required'],
            [['userID'], 'integer'],
            [['accessToken'], 'string', 'max' => 32],
            [['userID'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userID' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tokenID' => 'Token ID',
            'userID' => 'User ID',
            'accessToken' => 'Access Token',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'userID']);
    }
}
